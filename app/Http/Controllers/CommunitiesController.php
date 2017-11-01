<?php
/**
 * This controller handles all actions related to Communities (Hubs) for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Auth;
use Theme;
use Input;
use Validator;
use Redirect;
use Config;
use App\Models\ExchangeType;
use Pagetheme;
use Mail;
use Helper;
use Carbon\Carbon;
use DB;
use Log;


class CommunitiesController extends Controller
{

    protected $community;

    public function __construct(Community $community)
    {
        $this->community = $community;
    }


    /**
     * Returns the homepage view
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return View
     */
    public function getHomepage()
    {
        return view('home');
    }


    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content to display the entries within a community, which
     * is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::getDatatable() method that generates the JSON response
     * @since  [v1.0]
     * @return View
     */
    public function getEntriesView()
    {
        return view('browse');
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content to display the entries within a community, which
     * is generated in getDatatable. Kiosk blade simply displays without
     * header or footer
     *
     * @author [D.Linnard] [<dslinnard@gmail.com>]
     * @see    CommunitiesController::getDatatable() method that generates the JSON response
     * @since  [v1.0]
     * @return View
     */
    public function getKioskEntriesView()
    {
        return view('kiosk');
    }

    /**
     * Returns a view that allows a user to request access to a community that is
     * non-public.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return View
     */
    public function getRequestAccess(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            // find out whether they have already asked to join this share
            $request_count = $request->whitelabel_group->getRequestCount($user->id);

            LOG::debug("getRequestAccess: request_count = " . $request_count);
            return view('request-access',
                ['request_count' => $request_count, 'name' => $request->whitelabel_group->name]);
        }
        else {
            // not logged in so send them to the signup page
            LOG::debug("getRequestAccess: user is not logged in so redirect them");
            return view('request-access',
                ['request_count' => $request_count, 'name' => $request->whitelabel_group->name]);
        }
    }

    /**
     * Stores the access request
     *
     * @todo   Send an email to the community owner and add request to community request table
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::getRequestAccess()
     * @since  [v1.0]
     * @return Redirect
     * @todo   : send email to admin
     */
    public function postRequestAccess(Request $request)
    {
        $user = Auth::user();
        $request_count = $request->whitelabel_group->getRequestCount($user->id);
        LOG::debug("postRequestAccess. request_count: " . $request_count);

        if (!$request_count) {
            DB::table('community_join_requests')->insert(
                [
                    'user_id'      => $user->id,
                    'community_id' => $request->whitelabel_group->id,
                    'message'      => e(Input::get('message')),
                ]
            );
            $request_count = 1;
        }

        // redirect them back to same form page, but this time display different content
        return view('request-access', ['request_count' => $request_count, 'justSubmitted' => true, 'name' => $request->whitelabel_group->name]);
    }

    /**
     * Gets a list of join requests for the community
     *
     * @author [D. Linnard] [<dslinnard@yahoo.com>]
     * @param $request
     * @since  [v1.0]
     * @return View
     */
    public function getJoinRequests(Request $request)
    {
        $join_requests = $request->whitelabel_group->requests()->get();
        return view('join_requests')->with('join_requests', $join_requests);
    }

    /**
     * Returns a view lists the members of a community.
     *
     * @todo   Integrate server-side datatables
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::getDatatable() method that generates the JSON response
     * @since  [v1.0]
     * @return View
     */
    public function getMembers(Request $request)
    {
        $members = $request->whitelabel_group->members()->get();
        return view('members')->with('members', $members);
    }

    /**
     * Returns a view that displays the form to create a community.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::postCreate()
     * @since  [v1.0]
     * @return View
     */
    public function getCreate()
    {
        $themes = \App\Models\Pagetheme::select('name')->where('public', '=', 1)->get()->pluck('name');
        return view('communities.edit')->with('themes', $themes);
    }


    /**
     * Validates and stores the data for a new community. This method also handles
     * creating a subscription in Stripe for the user.
     *
     * @todo   Rip out Cartalyst's commercial stripe billing package and use Stripe native
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::getCreate()
     * @since  [v1.0]
     * @param Request $request
     * @return Redirect
     */
    public function postCreate(Request $request)
    {
        $token = $request->input('stripeToken');

        // No stripe token - something went wrong :(
        if (!isset($token)) {
            return Redirect::back()->withInput()->with('error',
                'Something went wrong. Please make sure javascript is enabled in your browser.');
        }
        log::debug("postCreate: token = " . $token);

        $community = new Community();
        $community->name = e($request->input('name'));
        $community->subdomain = strtolower(e($request->input('subdomain')));
        $community->group_type = e($request->input('group_type'));
        $community->created_by = Auth::user()->id;

        if ($community->isInvalid()) {
            return Redirect::back()->withInput()->withErrors($community->getErrors());
        }

        $customer = Auth::user();
        $metadata = array(
            'name'      => $customer->name,
            'subdomain' => strtolower(e(Input::get('subdomain'))) . config('session.domain'),
            'email'     => $customer->email,
            'hub_name'  => e(Input::get('name')),
        );

        if ($customer->stripe_id == '') {
            // Create the Stripe customer
            $customer->createStripeCustomer(
                [
                    'email'       => $customer->email,
                    'description' => 'Name: ' . $customer->getDisplayName() . ', Hub Name: ' . e($request->input('name')),
                    'metadata'    => $metadata,
                ]
            );

            log::debug("postCreate: customer did not exist, new id = " . $customer->stripe_id);

        }
        else {
            log::debug("postCreate: customer does exist " . $customer->stripe_id);
        }

        $data['name'] = $customer->getDisplayName();
        $data['email'] = $customer->email;
        $data['community_name'] = e($request->input('name'));
        $data['subdomain'] = strtolower($request->input('subdomain'));
        $data['type'] = e($request->input('subscription_type'));

        if (config('app.debug')) {
            // this is for testing only
            $data['logo'] = 'https://anyshare.coop/assets/img/hp/anyshare-logo-web-retina.png';
        }
        else {
            $data['logo'] = config('app.url') . '/assets/img/hp/anyshare-logo-web-retina.png';
        }

        if (!$customer->save()) {
            return Redirect::back()->withInput()->with('error', 'Something went wrong.');
        }

        try {
            $card = $customer->card()->makeDefault()->create($token);
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->with('error',
                'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '');
        }

        // Create the subscription
        try {
            $stripe_subscription = $customer
                ->subscription()
                ->onPlan(e($request->input('subscription_type')))
                //->trialFor(Carbon::now()->addDays(15))
                ->create();

            // set the given discount
            if (Input::has('coupon')) {
                try {
                    $customer->applyStripeDiscount(e($request->input('coupon')));
                } catch (\Exception $e) {
                    return Redirect::back()->withInput()->with('error',
                        'Something went wrong while trying to process your coupon request: ' . $e->getMessage() . '');
                }
            }

        } catch (\Exception $e) {
            return Redirect::back()->withInput()->with('error',
                'Something went wrong creating your subscription: ' . $e->getMessage() . '');
        }

        $customer->subscription()->syncWithStripe();
        $customer->card()->syncWithStripe();

        if ($community->save()) {
            //Log::debug('New site '.$community->subdomain.' created successfully. Redirecting to https://'.$community->subdomain.'.'.config('app.domain'));

            // Save the community_id to the subscriptions table
            $subscription = \App\Models\CommunitySubscription::where('stripe_id', '=',
                $stripe_subscription->stripe_id)->first();
            $subscription->community_id = $community->id;
            $subscription->save();

            $community->members()->attach(Auth::user(), ['is_admin' => true]);
            $community->exchangeTypes()->saveMany(\App\Models\ExchangeType::all());

            Mail::send(
                ['text' => 'emails.welcomeText', 'html' => 'emails.welcomeHTML'],
                $data,
                function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])->subject('Welcome to AnyShare!');
                }
            );

            return redirect('https://' . $community->subdomain . '.' . config('app.domain') . '/share/edit')->with('success',
                trans('general.community.save_success'));
        }
    }


    /**
     * Returns a view that makes a form to edit community details.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::postEdit()
     * @since  [v1.0]
     * @return View
     */
    public function getEdit(Request $request)
    {
        $themes = \App\Models\Pagetheme::select('name')->where('public', '=', 1)->get()->pluck('name');

        $community = Community::find($request->whitelabel_group->id);
        $exchanges = $community->exchangeTypes;
        $allowed_exchanges = array();
        foreach ($exchanges as $exchange) {
            $allowed_exchanges[$exchange->id] = $exchange->id;
        }

        $all_exchange_types = \App\Models\ExchangeType::all();
        return view('community.edit')->with('community', $community)->with('allowed_exchanges',
            $allowed_exchanges)->with('all_exchange_types', $all_exchange_types)->with('themes', $themes);
    }


    /**
     * Validates and stores the edited community data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    CommunitiesController::getEdit()
     * @since  [v1.0]
     * @return Redirect
     */
    public function postEdit(Request $request)
    {
        $community = Community::find($request->whitelabel_group->id);

        $community->name = e(Input::get('name'));
        $community->subdomain = e(Input::get('subdomain'));
        $community->group_type = e(Input::get('group_type'));
        $community->about = e(Input::get('about'));
        $community->welcome_text = e(Input::get('welcome_text'));
        $community->slack_endpoint = e(Input::get('slack_endpoint'));
        $community->slack_botname = e(Input::get('slack_botname'));
        $community->slack_channel = e(Input::get('slack_channel'));
        $community->slack_slash_want_token = e(Input::get('slack_slash_want_token'));
        $community->slack_slash_have_token = e(Input::get('slack_slash_have_token'));
        $community->slack_slash_members_token = e(Input::get('slack_slash_members_token'));
        $community->ga = e(Input::get('ga'));
        $community->show_info_bar = e(Input::get('show_info_bar'));
        $community->entry_layout = e(Input::get('entry_layout'));
        $community->color = e(Input::get('theme_color'));
        $community->wrld3d = e(Input::get('wrld3d'));

        if ($community->show_info_bar == null) {
            $community->show_info_bar = 1;
        }

        if (Input::get('location')) {
            $community->location = e(Input::get('location'));
            $latlong = Helper::latlong(Input::get('location'));
        }

        if (Input::hasFile('profile_img')) {
            $community->uploadImage(Auth::user(), Input::file('profile_img'), 'community-profiles');
        }

        if (Input::hasFile('cover_img')) {
            $community->uploadImage(Auth::user(), Input::file('cover_img'), 'community-covers');
        }

        if (Input::hasFile('logo')) {
            $community->uploadImage(Auth::user(), Input::file('logo'), 'community-logos');
        }


        if ((isset($latlong)) && (is_array($latlong)) && (isset($latlong['lat']))) {
            $community->latitude = $latlong['lat'];
            $community->longitude = $latlong['lng'];
        }

        if (!$community->save()) {
            return Redirect::back()->withInput()->withErrors($community->getErrors());
        }

        if (Input::has('exchange_types')) {
            $community->exchangeTypes()->sync(Input::get('exchange_types'));
        }
        else {
            $community->exchangeTypes()->sync(ExchangeType::all());
        }


        return redirect()->route('community.edit.form')->with('success',
            trans('general.community.messages.save_edits'));
    }
}

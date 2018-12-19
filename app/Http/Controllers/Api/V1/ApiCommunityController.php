<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\User;
use \App\Http\Transformers\EntriesTransformer;
use \App\Http\Transformers\GlobalTransformer;
use Helper;
use Input;

class ApiCommunityController extends Controller
{

	
    /* 
     *  Send request to join the open community
     */
    public function joinCommunity(Request $request, $community_id) {

        $community = Helper::getCommunity($community_id);
         \DB::beginTransaction();
        try { 
            if ($community->isOpen()) {
                auth('api')->user()->communities()->attach([$community->id]);

            }
            else {

                return view('request-access', ['error'=>'closed', 'name' => $community->name] );
            }

        } catch (\Exception $e) {                
            \DB::rollback();  
                return Helper::sendResponse(502, 'Unable to join '.$community->name);
        
        } finally { 
            \DB::commit();
                return Helper::sendResponse(200, 'You have joined '.$community->name.'!');
        }
    }

    /*
     * Leave a community
     */
    public function leaveCommunity(Request $request, $community_id) {

            
            $community = Helper::getCommunity($community_id);
           
            if (isset($community)) {
                if (auth('api')->user()->communities()->detach($community->id)) {
                    return Helper::sendResponse(200, 'You have left the Share, "'.$community->name.'"');
                }
                else {
                    return Helper::sendResponse(502, 'Unable to leave the Share, "'.$community->name.'"');
                   
                }
            }
        
        return Helper::sendResponse(422, 'Unable to leave the Share, "'.$community->name.'"');
    }
    
    /*
     * Start sharing network with the payment method
     * Refere page is this /share/new
     */
    public function startCommunity(){

        $token = $request->input('stripeToken');

        // No stripe token - something went wrong :(
        if (!isset($token)) {
            return Helper::sendResponse(502, 'Something went wrong. Please make sure javascript is enabled in your browser.', []);
        }
        //log::debug("postCreate: token = " . $token);

        $community = new Community();
        $community->name = e($request->input('name'));
        $community->subdomain = strtolower(e($request->input('subdomain')));
        $community->group_type = e($request->input('group_type'));
        $community->created_by = auth('api')->user()->id;

        if ($community->isInvalid()) {
            return Helper::sendResponse(502, $community->getErrors(), []);
        }

        $customer = auth('api')->user();
        $metadata = [
            'name'      => $customer->name,
            'subdomain' => strtolower(e(Input::get('subdomain'))) . config('session.domain'),
            'email'     => $customer->email,
            'hub_name'  => e(Input::get('name')),
        ];

        if ($customer->stripe_id == '') {
            // Create the Stripe customer
            $customer->createStripeCustomer(
                [
                    'email'       => $customer->email,
                    'description' => 'Name: ' . $customer->getDisplayName() . ', Hub Name: ' . e($request->input('name')),
                    'metadata'    => $metadata,
                ]
            );

            //log::debug("postCreate: customer did not exist, new id = " . $customer->stripe_id);
        } else {
            //log::debug("postCreate: customer does exist " . $customer->stripe_id);
        }

        $data['name'] = $customer->getDisplayName();
        $data['email'] = $customer->email;
        $data['community_name'] = e($request->input('name'));
        $data['subdomain'] = strtolower($request->input('subdomain'));
        $data['type'] = e($request->input('subscription_type'));

        if (config('app.debug')) {
            // this is for testing only
            $data['logo'] = 'https://anyshare.coop/assets/img/hp/anyshare-logo-web-retina.png';
        } else {
            $data['logo'] = config('app.url') . '/assets/img/hp/anyshare-logo-web-retina.png';
        }

        if (!$customer->save()) {

            return Helper::sendResponse(502, 'Something went wrong.', $customer->getErrors());
        }

        try {
            $card = $customer->card()->makeDefault()->create($token);
        } catch (\Exception $e) {
            
            return Helper::sendResponse(502, 'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '', []);

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
                    return Helper::sendResponse(502, 'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '', []);
                }
            }
        } catch (\Exception $e) {
            return Helper::sendResponse(502, 'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '', []);
        }

        $customer->subscription()->syncWithStripe();
        $customer->card()->syncWithStripe();

        if ($community->save()) {
            //log::debug('New site '.$community->subdomain.' created successfully. Redirecting to https://'.$community->subdomain.'.'.config('app.domain'));

            // Save the community_id to the subscriptions table
            $subscription = CommunitySubscription::where('stripe_id', '=', $stripe_subscription->stripe_id)->first();
            $subscription->community_id = $community->id;
            $subscription->save();

            $community->members()->attach(auth('api')->user(), ['is_admin' => true]);
            $community->exchangeTypes()->saveMany(\App\Models\ExchangeType::all());

            Mail::send(
                ['text' => 'emails.welcomeText', 'html' => 'emails.welcomeHTML'],
                $data,
                function ($message) use ($data) {
                    $message->to($data['email'], $data['name'])->subject('Welcome to AnyShare!');
                }
            );
            return Helper::sendResponse(200, trans('general.community.save_success'), []);
        }
    }


     /*
      * Get basic setting of community
      * Refere page is this /share/edit
      */
    public function defaultExchangeTypes(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);
        $trnsform = GlobalTransformer::transform_allexchnge_types(\App\Models\ExchangeType::all());

        return Helper::sendResponse(200, '', $trnsform);
    }

     /*
      * Get basic setting of community
      * Refere page is this /share/edit
      */
    public function getBasicSetting(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);

        $data['themes'] = \App\Models\Pagetheme::select('name')->where('public', '=', 1)->get()->pluck('name');

        $exchanges = $community->exchangeTypes;

        $data['allowed_exchanges'] = $exchanges->mapWithKeys(function ($exc) {
            return [$exc->getKey() => $exc->getKey()];
        })->toArray();

        $data['all_exchange_types'] = \App\Models\ExchangeType::all();

        $data['poisets'] = ($community->wrld3d && $community->wrld3d->get('dev_token'))
            ? (new PoiManager($community))->getPoisets()
            : collect([]);
        $data['community'] = $community;

        return Helper::sendResponse(200, '', $data);
        // return $data;
    }
     /*
      * Post basic setting of community
      * Refere page is this /share/edit
      */
    public function postBasicSetting(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);

        if (Input::has('cover_image_delete')) {
            //log::debug("postEdit: delete_cover_image: " . $community->cover_img);
            $community->deleteCover();
        }
        if (Input::has('logo_image_delete')) {
            //log::debug("postEdit: delete_logo_image: " . $community->logo);
            $community->deleteLogo();
        }
        $community->name = e(Input::get('name'));
        $community->subdomain = e(Input::get('subdomain'));
        $community->group_type = e(Input::get('group_type'));
        $community->about = e(Input::get('about'));
        $community->location = e(Input::get('location'));
        $latlong = (Input::get('location')) ? collect(Helper::latlong(Input::get('location'))) : collect([]);
        $community->latitude = $latlong->get('lat');
        $community->longitude = $latlong->get('lng');
        $community->color = e(Input::get('theme_color'));
        $community->entry_layout = e(Input::get('entry_layout'));
        if (Input::has('exchange_types')) {
            $community->exchangeTypes()->sync(Input::get('exchange_types'));
        } else {
            $community->exchangeTypes()->sync(ExchangeType::all());
        }

        if (!$community->save()) {
                return Helper::sendResponse(502, '',$community->getErrors());
        }
        return Helper::sendResponse(200, trans('general.community.messages.save_edits'));
    }

     /*
      * Post image setting of community
      * Refere page is this /share/edit
      */
    public function postImageSetting(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);

        if (Input::hasFile('cover_img')) {
            $community->uploadImage(auth('api')->user(), Input::file('cover_img'), 'community-covers');
        }

        if (Input::hasFile('logo')) {
            $community->uploadImage(auth('api')->user(), Input::file('logo'), 'community-logos');
        }

        if (Input::hasFile('profile_img')) {
            $community->uploadImage(auth('api')->user(), Input::file('profile_img'), 'community-profiles');
        }

        if (!$community->save()) {
            return Helper::sendResponse(502, '',$community->getErrors());
        }
        return Helper::sendResponse(200, trans('general.community.messages.save_edits'));
        
    }

     /*
      * Post advance setting of community
      * Refere page is this /share/edit
      */
    public function postAdvanceSetting(Request $request, $community_id) {
        $community = Helper::getCommunity($community_id);

        $community->welcome_text = e(Input::get('welcome_text'));
        $community->slack_endpoint = e(Input::get('slack_endpoint'));
        $community->slack_botname = e(Input::get('slack_botname'));
        $community->slack_channel = e(Input::get('slack_channel'));
        $community->slack_slash_want_token = e(Input::get('slack_slash_want_token'));
        $community->slack_slash_have_token = e(Input::get('slack_slash_have_token'));
        $community->slack_slash_members_token = e(Input::get('slack_slash_members_token'));
        $community->ga = e(Input::get('ga'));
        $community->show_info_bar = e(Input::get('show_info_bar'));

        // Get the WRLD3D Data
        $wrld3dApiKey = explode(' - ', e(Input::get('wrld3d.api_key')));

        $community->wrld3d = collect([
            'dev_token' => e(Input::get('wrld3d.dev_token')),
            'api_key'   => count($wrld3dApiKey) === 2 ? $wrld3dApiKey[1] : null,
            'poiset'    => count($wrld3dApiKey) === 2 ? intval($wrld3dApiKey[0]) : null,
        ]);

        if ($community->show_info_bar == null) {
            $community->show_info_bar = 1;
        }

        if (!$community->save()) {
            return Helper::sendResponse(502, '',$community->getErrors());
        }
        return Helper::sendResponse(200, trans('general.community.messages.save_edits'));
    }
}
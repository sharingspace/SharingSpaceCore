<?php
/**
 * This controller handles all actions related to generic pages for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Theme;
use Log;
use Input;
use Mail;
use Redirect;

class PagesController extends Controller
{
    /**
    * Returns a view to display the homepage. This is tricky because the
    * homepage view will be different based on whether the viewer is looking
    * at the homepage of the corporate site or of a community.
    *
    * @todo   Find a more elegant way to handle the two different views.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since  [v1.0]
    * @return View
    */
    public function getHomepage(Request $request)
    {
        if ($request->whitelabel_group) {
            $entries = $request->whitelabel_group->entries()->with('author', 'exchangeTypes', 'media')->orderBy('created_at', 'desc')->get();
            return view('home')->with('entries', $entries);
        }
        else {
            $communities = \App\Models\Community::orderBy('created_at', 'DESC')->IsPublic()->take(20)->get();
            return view('home')->with('communities', $communities);
        }
    }

   /**
    * Returns a view to display the coop page. The reason I just don't
    * call the view from the route as I need to know whether the user is logged
    * in or not and this seemed the cleanest way
    *
    * @author [D. Linnard] [<dslinnard@yahoo.com>]
    * @since  [v1.0]
    * @return View
    */
    public function getCoopPage(Request $request)
    {
        return view('coop')->with('signedIn', Auth::check());
    }


    /**
    * Sends an email to request financial assistance.
    *
    * @author [David Linnard] [<dslinnard@gmail.com>]
    * @since  [v1.0]
    * @return Redirect
    */
    public function postFinancialAssist(Request $request)
    {
        $data['firstName'] = Input::get('firstName');
        $data['lastName'] = Input::get('lastName');
        $data['email'] = Input::get('email');
        $data['toEmail'] = 'info@anyshare.coop';
        $data['subject'] = 'Application for free Anyshare hub';
        $data['howUse'] = Input::get('howUse');
        $data['budget'] = Input::get('budget');
        $data['timePeriod'] = Input::get('timePeriod');
        $data['market'] = Input::get('market');
        $data['logo'] = public_path()."/assets/img/anyshare-logo-squares.png";

        $sent = Mail::send(
            array('emails.freeAnyshare', 'emails.freeAnyshareText'), ['data'=>$data],
            function ($m) use ($data) {
                $m->from($data['email'], $data['firstName'].' '.$data['lastName'])->to($data['toEmail'], 'AnyShare')->subject($data['subject']);
            }
        );

        if( $sent) {
            return Redirect::back()->with('success', trans('pricing.financial_assist.success'));
        }
        else {
            return Redirect::back()->with('error', trans('pricing.financial_assist.error'));
        }

    }


    /**
     * Validates and stores a new co-op membership charge
     *
     * @todo   Rip out Cartalyst's commercial stripe billing package and use Stripe native
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see    PageController::getCoopSignup()
     * @since  [v1.0]
     * @return Redirect
     */
    public function postChargeCoop(Request $request)
    {
        $token = Input::get('stripeToken');

        // No stripe token - something went wrong :(
        if (!isset($token)) {
            log::debug("postChargeCoop: no token");
            return Redirect::back()->withInput()->with('error', 'Something went wrong. Please make sure javascript is enabled in your browser.');
        }

        $customer = Auth::user();
        $metadata = [];

        if ($customer->stripe_id=='') {
            // Create the Stripe customer

            $customer->createStripeCustomer(
                [
                    'email' => $customer->email,
                    'description' => 'Name: '.$customer->getDisplayName(),
                    'metadata' => $metadata,
                ]
            );
        }

        $data['name'] = $customer->getDisplayName();
        $data['email'] = $customer->email;

        if (!$customer->save()) {
            log::debug("postChargeCoop: save failed");

            return Redirect::back()->withInput()->with('error', 'Something went wrong.');
        }

        try {
            $card = $customer->card()->makeDefault()->create($token);
        } catch (\Exception $e) {
            log::debug("postChargeCoop: create failed");

            return Redirect::back()->withInput()->with('error', 'Something went wrong while trying to authorise your card: '.$e->getMessage().'');
        }

        // Create the charge
        try {
            // Create the charge
            $charge = $customer
                ->charge()
                ->create(50.00, [
                    'description' => 'AnyShare COOP Membership',
                ]);
        } catch (\Exception $e) {
            log::debug("postChargeCoop: charge failed");

            return Redirect::back()->withInput()->with('error', 'Something went wrong while authorizing your card: '.$e->getMessage().'');
        }

        $customer->card()->syncWithStripe();
        if( config('app.debug')) {
            // this is for testing only
            $data['logo'] = 'https://anyshare.coop/assets/img/hp/anyshare-logo-web-retina.png';
        }
        else {
            $data['logo'] = config('app.url').'/assets/img/hp/anyshare-logo-web-retina.png';
        }

        $data['interest'] = Input::get('interest');
        $data['involved'] = Input::get('involved');

        $emails = [$data['email'], 'info@anyshare.coop'];

        Mail::send(
            ['html' => 'emails.coop-welcomeHTML', 'text' => 'emails.coop-welcomeText'],
            $data,
            function ($message) use ($data, $emails) {
                $message->to($emails, $data['name'])->subject('Welcome to AnyShare!');
            }
        );

        return redirect()->route('coop_success');
    }
}

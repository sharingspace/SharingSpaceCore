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
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Auth;
use Theme;
use Log;
use Input;
use Mail;

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
    public function getHomepage(Request $request, $hp = null)
    {

        if ($request->whitelabel_group) {
            LOG::debug('Whitelabel routing: Passed middleware, start getHomepage');
            if (Auth::check()) {
                if (Auth::user()->canSeeCommunity($request->whitelabel_group)) {
                    LOG::debug('Whitelabel routing: User can see this homepage');
                    $entries = $request->whitelabel_group->entries()->with('author', 'exchangeTypes', 'media')->orderBy('created_at', 'desc')->get();
                    return view('home')->with('entries', $entries);
                } else {
                    LOG::debug('Whitelabel routing: User is logged in but cannot see this homepage');
                    return redirect()->route('community.request-access.form')->withError('You must be a member of this group to view this page.');
                }


            } else {
                if ($request->whitelabel_group->group_type == 'S') {
                    return view('auth/login-unbranded')->withError('You must be logged in and a member to see this.');
                } else {
                    return view('auth/login')->withError('You must be logged in and a member to see this.');
                }

            }



        } else {
            $communities = \App\Community::orderBy('created_at', 'DESC')->IsPublic()->take(20)->get();
            return view('home'.$hp)->with('communities', $communities);
        }

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
         /* Mail::raw("Testing", function ($message) {
            $message->from('dslinnard@gmail.com', 'David');
            $message->to('dslinnard@yahoo.com', 'David')
              ->subject('LaravelGMail App!');
        });*/
       
        $data['firstName'] = Input::get('firstName');
        $data['lastName'] = Input::get('lastName');
        $data['email'] = Input::get('email');
        $data['toEmail'] = 'info@anysha.re';
        $data['subject'] = 'Application for free Anyshare hub';;
        $data['howUse'] = Input::get('howUse');
        $data['budget'] = Input::get('budget');
        $data['timePeriod'] = Input::get('timePeriod');
        $data['market'] = Input::get('market');

        $sent = Mail::send(
            array('emails.freeAnyshare', 'emails.freeAnyshareText'), ['data'=>$data],
            function ($m) use ($data) {
                $m->from($data['email'], 'dave')->to($data['toEmail'], 'AnyShare')->subject($data['subject']);
            }
        ); 

        if( $sent) {
            return Redirect::back()->with('success', trans('pricing.financial_assist.success'));
        }
        else {
            return Redirect::back()->with('error', trans('pricing.financial_assist.error'));
        }

    }
}

<?php
/**
 * This controller handles all admin actions
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Auth;
use Gate;
use \App\CommunitySubscription;


class AdminController extends Controller
{

    /**
     * Returns customer listing
     *
     * @todo Make this use an Ajax call for faster loading
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since  [v1.0]
     * @return View
     */
    public function getCustomerList()
    {
        if (Gate::denies('admin')) {
            abort(404);
        }
        $subscriptions = CommunitySubscription::with('user','community')->where('active','=','1')->orderBy('created_at','DESC')->paginate(100);
        return view('admin/customers')->with('subscriptions', $subscriptions);

    }



}

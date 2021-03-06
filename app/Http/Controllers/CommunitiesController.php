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

use App\Helpers\Wrld3D\PoiManager;
use App\Models\Community;
use App\Models\CommunitySubscription;
use App\Models\ExchangeType;
use Auth;
use Config;
use DB;
use Helper;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission as P;
use Illuminate\Http\Request;
use Input;
use Log;
use Mail;
use Permission;
use Redirect;
use App\Models\AskPermission;
use App\Models\User;
use App\Models\oAuthClient;
use App\Helpers\Passport\AccessToken;




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

            //log::debug("getRequestAccess: request_count = " . $request_count);
            return view(
                'request-access',
                ['request_count' => $request_count, 'name' => $request->whitelabel_group->name]
            );
        } else {
            // not logged in so send them to the signup page
            //log::debug("getRequestAccess: user is not logged in so redirect them");
            return view(
                'request-access',
                ['request_count' => $request_count, 'name' => $request->whitelabel_group->name]
            );
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
        //log::debug("postRequestAccess. request_count: " . $request_count);

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
        if(!Permission::checkPermission('approve-new-member-permission', $request->whitelabel_group)) {
            return view('errors.403');       
        }
        
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
        
        if(!Permission::checkPermission('view-members-permission', $request->whitelabel_group)) {
            return view('errors.403');       
        }

        //$data['admin'] = Permission::adminRole('view-members-permission',$request->whitelabel_group);


        $data['members'] = $request->whitelabel_group->members()->get();

        $data['roles'] = Helper::injectselect(Role::where('community_id', $request->whitelabel_group->id)->pluck('display_name','id')->toArray(),'Assign Role');

        // dd($data['admin']);
       
       // $data['new_role_url'] = route('admin.assign-role.create');


        return view('members',$data);
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
            return Redirect::back()->withInput()->with(
                'error',
                'Something went wrong. Please make sure javascript is enabled in your browser.'
            );
        }
        //log::debug("postCreate: token = " . $token);

        $community = new Community();
        $community->name = e($request->input('name'));
        $community->subdomain = strtolower(e($request->input('subdomain')));
        $community->group_type = e($request->input('group_type'));
        $community->created_by = Auth::user()->id;

        if ($community->isInvalid()) {
            return Redirect::back()->withInput()->withErrors($community->getErrors());
        }

        $customer = Auth::user();
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
            return Redirect::back()->withInput()->with('error', 'Something went wrong.');
        }

        try {
            $card = $customer->card()->makeDefault()->create($token);
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->with(
                'error',
                'Something went wrong while trying to authorise your card: ' . $e->getMessage() . ''
            );
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
                    return Redirect::back()->withInput()->with(
                        'error',
                        'Something went wrong while trying to process your coupon request: ' . $e->getMessage() . ''
                    );
                }
            }
        } catch (\Exception $e) {
            return Redirect::back()->withInput()->with(
                'error',
                'Something went wrong creating your subscription: ' . $e->getMessage() . ''
            );
        }

        $customer->subscription()->syncWithStripe();
        $customer->card()->syncWithStripe();

        if ($community->save()) {
            //log::debug('New site '.$community->subdomain.' created successfully. Redirecting to https://'.$community->subdomain.'.'.config('app.domain'));

            // Save the community_id to the subscriptions table
            $subscription = CommunitySubscription::where('stripe_id', '=', $stripe_subscription->stripe_id)->first();
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

            return redirect('https://' . $community->subdomain . '.' . config('app.domain') . '/share/edit')->with(
                'success',
                trans('general.community.save_success')
            );
        }
    }

    public function createDefaultRoles($request) {

        \DB::beginTransaction();
        try { 

            $name = $request->whitelabel_group->name.'_Administrator';
            $role_exist = Role::where('name',$name)
                                    ->where('community_id',$request->whitelabel_group->id)
                                    ->first();

            if(empty($role_exist)) {
                    
                $role = Role::create([
                    'name' => $name,
                    'guard_name' => 'web',
                    'display_name' => 'Administrator',
                    'community_id' =>  $request->whitelabel_group->id
                ]);

                foreach (P::all() as $key => $permission) {
                    $role->givePermissionTo($permission->id);
                }
            } else {
                \DB::table('role_has_permissions')->where('role_id',$role_exist->id)->delete();
                foreach (P::all() as $key => $permission) {
                    $role_exist->givePermissionTo($permission->id);
                }
            }
            
        } catch (\Exception $e) {                
            \DB::rollback();          
        }
        \DB::commit();
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
        
        $this->createDefaultRoles($request);

        if(!Permission::checkPermission('edit-sharing-network-permission', $request->whitelabel_group)) {
            return view('errors.403');       
        }

        $themes = \App\Models\Pagetheme::select('name')->where('public', '=', 1)->get()->pluck('name');

        $exchanges = $request->whitelabel_group->exchangeTypes;

        $allowed_exchanges = $exchanges->mapWithKeys(function ($exc) {
            return [$exc->getKey() => $exc->getKey()];
        })->toArray();

        $all_exchange_types = \App\Models\ExchangeType::all();

        $poisets = ($request->whitelabel_group->wrld3d && $request->whitelabel_group->wrld3d->get('dev_token'))
            ? (new PoiManager($request->whitelabel_group))->getPoisets()
            : collect([]);

        if(!Permission::checkPermission('manage-role', $request->whitelabel_group)) {
            return view('errors.403');       
        }
            
        
        $data['permissions'] = P::all();
        $data['roles'] = Role::where('community_id', $request->whitelabel_group->id)->get();
        // $data['session'] = \Session::get('_old_input');
        return view('community.edit',$data)
            ->with('community', $request->whitelabel_group)
            ->with('poisets', $poisets)
            ->with('allowed_exchanges', $allowed_exchanges)
            ->with('all_exchange_types', $all_exchange_types)
            ->with('themes', $themes);
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

        $community->location = e(Input::get('location'));
        $latlong = (Input::get('location')) ? collect(Helper::latlong(Input::get('location'))) : collect([]);
        $community->latitude = $latlong->get('lat');
        $community->longitude = $latlong->get('lng');

        if (Input::hasFile('profile_img')) {
            $community->uploadImage(Auth::user(), Input::file('profile_img'), 'community-profiles');
        }

        if (Input::has('cover_image_delete')) {
            //log::debug("postEdit: delete_cover_image: " . $community->cover_img);
            $community->deleteCover();
        }

        if (Input::has('logo_image_delete')) {
            //log::debug("postEdit: delete_logo_image: " . $community->logo);
            $community->deleteLogo();
        }

        if (Input::hasFile('cover_img')) {
            $community->uploadImage(Auth::user(), Input::file('cover_img'), 'community-covers');
        }

        if (Input::hasFile('logo')) {
            $community->uploadImage(Auth::user(), Input::file('logo'), 'community-logos');
        }
        if (!$community->save()) {
            if($request->ajax()){
                return Helper::ajaxresponse(false, 'Failed', $community->getErrors());
            }
            return Redirect::back()->withInput()->withErrors($community->getErrors());
        }

        if (Input::has('exchange_types')) {
            $community->exchangeTypes()->sync(Input::get('exchange_types'));
        } else {
            $community->exchangeTypes()->sync(ExchangeType::all());
        }

        if(!Permission::checkPermission('manage-role', $request->whitelabel_group)) {
            return view('errors.403');       
        }
        
        $role_tab = '';
        if($request->rolename != ""){
            $role_tab = 'role';
            $role_name = $request->whitelabel_group->name.'_'.$request->rolename;
            
            $unique = Role::where('community_id', $request->whitelabel_group->id)
                            ->where('id', '!=', $request->role_id)
                            ->where('name', $role_name)
                            ->first();
            
            if($unique) {
                if($request->ajax()){
                    $error[][] = trans('general.role.error.unique');
                    return Helper::ajaxresponse(false, $role_tab, $error);
                }
                return Redirect::route('_edit_share', array('role_tab' => $role_tab))->with('error', trans('general.role.error.unique'));
            }
            if($request->permissions == '') {
                if($request->ajax()){
                    $error[][] = trans('general.role.error.role-select');
                    return Helper::ajaxresponse(false, $role_tab, $error);
                }
                return Redirect::route('_edit_share', array('role_tab' => $role_tab))->with('error', trans('general.role.error.role-select'));
            }
            \DB::beginTransaction();
            try {

                if($request->role_id !='') {
                    $role = Role::where('community_id', $request->whitelabel_group->id)->findorfail($request->role_id);

                    $role->update([
                        'name' => $role_name,
                        'display_name' =>$request->rolename,
                    ]);
                
                } else {
                    

                    $role =  Role::create([
                                    'name' => $role_name,
                                    'display_name' =>$request->rolename,
                                    'community_id' =>  $request->whitelabel_group->id,
                                ]);
                }

                \DB::table('role_has_permissions')->where('role_id',$request->role_id)->delete();
                foreach ($request->permissions as $key => $permission) {
                    $role->givePermissionTo($permission);
                }

            } catch (\Exception $e) {    

                \DB::rollback();  
                // dd($e);
                if($request->ajax()){
                    $error[][] = 'Something went to wrong';
                    return Helper::ajaxresponse(false, $role_tab, $error);
                }
            } finally { 
                \DB::commit();
                
                // $message = trans('general.role.updated');
            }

        }
        if($request->ajax()){
            return Helper::ajaxresponse(true, trans('general.community.messages.save_edits'), $role_tab);
        }            

        return Redirect::route('_edit_share', array('role_tab' => $role_tab))->with('success', trans('general.community.messages.save_edits'));
    }

    public function updatePois(Request $request)
    {
        $community = $request->whitelabel_group;

        if (!$community->wrld3d || !$community->wrld3d->get('poiset')) {
            return redirect()->back();
        }

        // Instantiate the Poi Manager and update entries
        //to have a POI associated to it.
        $poiManager = new PoiManager($community);

        $community->entries()
            ->whereNotNull('lat')
            ->whereNotNull('lng')
            ->get()
            ->filter(function ($item) {
                return is_null($item->wrld3d) || is_null($item->wrld3d->get('poi_id'));
            })
            ->map(function ($entry) use (&$es, $poiManager) {
                if (!$entry->hasGeolocation()) {
                    return null;
                }

                $poiManager->savePoi($entry);
            })
            ->filter();

        return redirect()->route('_edit_share')->with('success', 'Entries updated.');
    }

    public function getAskPermission()
    {

        $data['roles'] = Role::all();

        return view('askpermission.view', $data);
    }

    public function postAskPermission(Request $request)
    {

        $role_id = 0;
        // dd($request->selected->);
        if(!empty($request->selected)){
            $role_id = array_keys($request->selected)[0];
            Role::findorfail($role_id);
        }


        if($role_id == 0 && $request->message == ""){
            return redirect()->back();
        }
        // $this->validate($request,[
        //     'user_id' => 'required|string|max:255',
        //     'role_id' => 'required|string|max:255'
        // ]);

        \DB::beginTransaction();
        
        try { 

            
            AskPermission::create([
                'request_type' => 'Role',
                'community_id' => $request->whitelabel_group->id,
                'user_id' => \Auth::user()->id,
                'role_id' => $role_id,
                'is_accepted' => 0,
                'is_rejected' => 0,
                'custom_text' => $request->message,
            ]);


            
        } catch (\Exception $e) {
                        dd($e);
            \DB::rollback();  
        
        } finally { 
            \DB::commit();

            $message = trans('general.ask_permission.created');
            return redirect()->back()->with('success',$message);
        }
    }


    public function getAskPermissionList(Request $request)
    {

        // if(!Permission::checkPermission('request-membership-permission', $request->whitelabel_group)) {
        //     return view('errors.403');       
        // }

        $data['asks'] = AskPermission::latest()->where('community_id',$request->whitelabel_group->id)->get();

        return view('askpermission.list', $data);

    }
    public function getAskPermissionView($id)
    {

        // if(!Permission::checkPermission('request-membership-permission', $request->whitelabel_group)) {
        //     return view('errors.403');       
        // }

        $data['ask'] = AskPermission::findorfail($id);
        
        $data['role'] = Role::findorfail($data['ask']->role_id);

        return view('askpermission.member-view',$data);
    }

    public function postAskPermissionGranted(Request $request)
    {

        // if(!Permission::checkPermission('request-membership-permission', $request->whitelabel_group)) {
        //     return view('errors.403');       
        // }

        $message = '';
        // dd($request->all());
        $data = AskPermission::find($request->id)->where('is_accepted','0')->where('is_rejected','0');
        

        if(count($data) > 0)
        {
            \DB::beginTransaction();
            try { 

                $user = User::findorfail($request->user_id);

                if($request->accept == 1)
                {
                    if(count($user->roles) > 0) {
                        $role_id = $user->roles()->first()->id;
                        $user->removeRole($role_id);
                    }

                    if($request->role_id != 0){
                        $user->assignRole($request->role_id);
                    }
                    
                    $data->update([
                        'is_accepted' => $request->accept,
                    ]);
                    $message = trans('general.ask_permission.update_accepted');
                    
                }
                else
                {
                    $data->update([
                        'is_rejected' => $request->reject,
                    ]);    
                    $message = trans('general.ask_permission.update_rejected');
                   // return redirect("admin/member/requests")->with('success',$message);
                }

            } catch (\Exception $e) {                
                \DB::rollback();  
            
            } finally { 
                \DB::commit();
                // dd($message);
                //$message = trans('general.assign_role.updated');
                return redirect("admin/member/requests")->with('success',$message);
            }
                
        }
        else
        {
            $message = trans('general.ask_permission.already_done');       
            return redirect("admin/member/requests")->with('success',$message);
        }
    }


    public function getApiDetail(Request $request)
    {
        
        
        $data['oauth_client'] = Community::find($request->whitelabel_group->id)->community_apis->first();

        
        return view('apis.view',$data);
    }

    public function postApiDetail(Request $request)
    {       
        \DB::beginTransaction();
        try { 


            $oauth_client = oAuthClient::create([
                            'user_id' => \Auth::user()->id, 
                            'name'    => $request->whitelabel_group->name,
                            'secret' => str_random(40),
                        ]);
            $oauth_client->community_apis()->attach($request->whitelabel_group->id);
     
        } catch (\Exception $e) {  
            \DB::rollback();  
        } finally { 
            
            \DB::commit();
            $message = trans('general.apis.created');
            return back()->with('success', $message);
        }      
    }
}


<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\User;
use \App\Http\Transformers\EntriesTransformer;
use Helper;

class ApiCommunityController extends Controller
{

	
    /* 
     *  Send request to join the open community
     */
    public function joinCommunity(Request $request, $community_id) {

        $community = Helper::getCommunity($community_id);
         \DB::beginTransaction();
        try { 
            if ($request->whitelabel_group->isOpen()) {
                auth('api')->user()->communities()->attach([$community->id]);

            }
            else {

                return view('request-access', ['error'=>'closed', 'name' => $community->name] );
            }

        } catch (\Exception $e) {                
            \DB::rollback();  
                return Helper::sendResponse(false, 'Unable to join '.$community->name);
        
        } finally { 
            \DB::commit();
                return Helper::sendResponse(true, 'You have joined '.$community->name.'!');
        }
    }

    /*
     * Leave a community
     */
    public function leaveCommunity(Request $request, $community_id) {

            
            $community = Helper::getCommunity($community_id);
           
            if (isset($community)) {
                if (Auth::user()->communities()->detach($community->id)) {
                    return Helper::sendResponse(true, 'You have left the Share, "'.$community->name.'"');
                }
                else {
                    return Helper::sendResponse(false, 'Unable to leave the Share, "'.$community->name.'"');
                   
                }
            }
        
        return Helper::sendResponse(false, 'Unable to leave the Share, "'.$community->name.'"');
    }
    
    /*
     * Start sharing network with the payment method
     * Refere page is this /share/new
     */
    public function startCommunity(){

        $token = $request->input('stripeToken');

        // No stripe token - something went wrong :(
        if (!isset($token)) {
            return $this->sendResponse(false, 'Something went wrong. Please make sure javascript is enabled in your browser.', []);
        }
        //log::debug("postCreate: token = " . $token);

        $community = new Community();
        $community->name = e($request->input('name'));
        $community->subdomain = strtolower(e($request->input('subdomain')));
        $community->group_type = e($request->input('group_type'));
        $community->created_by = Auth::user()->id;

        if ($community->isInvalid()) {
            return $this->sendResponse(false, $community->getErrors(), []);
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

            return $this->sendResponse(false, 'Something went wrong.', []);
        }

        try {
            $card = $customer->card()->makeDefault()->create($token);
        } catch (\Exception $e) {
            
            return $this->sendResponse(false, 'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '', []);

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
                    return $this->sendResponse(false, 'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '', []);
                }
            }
        } catch (\Exception $e) {
            return $this->sendResponse(false, 'Something went wrong while trying to authorise your card: ' . $e->getMessage() . '', []);
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
            return $this->sendResponse(true, trans('general.community.save_success'), []);
        }
    }


}
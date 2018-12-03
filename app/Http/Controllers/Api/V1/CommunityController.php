<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Community;
use Illuminate\Http\Request;
use App\Models\User;
use \App\Http\Transformers\EntriesTransformer;


class CommunityController extends Controller
{

	/*
     * Get All Community of authenticated user
     * Improvement: later need to add pagination
     */
    public function getAllCommunities(Request $request) {
        
        $user = auth('api')->user();
        return $this->sendResponse(true, '', $user->communities()->get());
    }

    public function joinCommunity() {
        
    }

    public function leaveCommunity() {

    }

    /*---------------------------------------------------------------------
	 * Frontend Apis 
	 --------------------------------------------------------------------*/


     public function registerMember(Request $request;) {

        $validator = Validator::make($request->all(), [ 
            'name' => 'required', 
            'email' => 'required|email', 
            'password' => 'required', 
            'password_confirmation' => 'required|same:password', 
        ]);

        if ($validator->fails()) { 
            return $this->sendResponse(false, $validator->errors(), []);        
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;

        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        
        $token->save();

        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
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
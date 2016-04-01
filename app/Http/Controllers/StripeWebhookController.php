<?php
/**
 * This controller handles all subscription billing actions for
 * the AnyShare application.
 *
 * PHP version 5.5.9
 *
 * @package AnyShare
 * @version v1.0
 */
namespace App\Http\Controllers;

use Cartalyst\Stripe\Billing\Laravel\Controllers\WebhookController as BaseWebhookController;

class StripeWebhookController extends BaseWebhookController
{
    /**
     * Handles a successful payment.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeSucceeded(array $payload)
    {
        $charge = $this->handlePayment($payload);

        // apply your own logic here if required

        return $this->sendResponse('Webhook successfully handled.');
    }

    /**
     * Handles a failed payment.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeFailed(array $payload)
    {
        $charge = $this->handlePayment($payload);

        // apply your own logic here if required

        return $this->sendResponse('Webhook successfully handled.');
    }

    /**
     * Handles a payment refund.
     *
     * @param  array $payload
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handleChargeRefunded(array $payload)
    {
        $charge = $this->handlePayment($payload);

        // apply your own logic here if required

        return $this->sendResponse('Webhook successfully handled.');
    }

    /**
     * Handles the payment event.
     *
     * @param  array $charge
     * @return \Cartalyst\Stripe\Billing\Models\IlluminateCharge
     */
    protected function handlePayment(array $charge)
    {
        $entity = $this->getBillable($charge['customer']);

        $entity->charge()->syncWithStripe();

        return $entity->charges()->whereStripeId($charge['id'])->first();
    }
}

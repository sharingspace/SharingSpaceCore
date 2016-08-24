<?php

/**
 * Part of the Stripe Billing Laravel package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Cartalyst PSL License.
 *
 * This source file is subject to the Cartalyst PSL License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe Billing Laravel
 * @version    2.0.2
 * @author     Cartalyst LLC
 * @license    Cartalyst PSL
 * @copyright  (c) 2011-2016, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Cartalyst\Stripe\Billing\Laravel\Card\Card;

class CartalystStripeBillingAddExpDateColumnToStripeCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stripe_cards', function (Blueprint $table) {
            $table->timestamp('exp_date')->after('exp_year')->nullable();
        });

        foreach (Card::all() as $card) {
            $card->exp_date = Carbon::createFromDate($card->exp_year, $card->exp_month);
            $card->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('stripe_cards', function (Blueprint $table) {
            $table->dropColumn('exp_date');
        });
    }
}

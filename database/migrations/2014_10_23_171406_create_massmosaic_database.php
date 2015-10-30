<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMassmosaicDatabase extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
         public function up()
         {

         // Update the users table
        Schema::table('users', function ($table) {
            $table->softDeletes();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('gravatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('location')->nullable();
            $table->decimal('latitude', 9, 2);
            $table->decimal('longitude', 9, 2);
            $table->string('imagefile')->nullable();
            $table->char('fb_url', 100)->default(NULL)->nullable();
			$table->char('twitter_url', 100)->default(NULL)->nullable();
			$table->char('pinterest_url', 100)->default(NULL)->nullable();
			$table->char('gplus_url', 100)->default(NULL)->nullable();
			$table->char('youtube_url', 100)->default(NULL)->nullable();
            $table->char('displayname',100)->default(NULL)->nullable();
            $table->char('cover_img',100)->default(NULL)->nullable();
            $table->boolean('post_to_fb')->default(1);
            $table->boolean('fave_to_fb')->default(1);
        });



	    /**
	     * Table: activity_stream
	     */
	    Schema::create('activity_stream', function($table) {
                $table->increments('activity_id')->unsigned();
                $table->integer('user_id')->nullable();
                $table->integer('tile_id')->nullable();
                $table->integer('group_id')->nullable();
                $table->string('action', 255)->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->timestamp('deleted_at')->nullable();
                $table->string('activity_type', 250)->nullable();
            });


	    /**
	     * Table: exchange_types
	     */
	    Schema::create('exchange_types', function($table) {
                $table->increments('type_id')->unsigned();
                $table->string('type_name', 255);
            });


	    /**
	     * Table: favorites
	     */
	    Schema::create('favorites', function($table) {
                $table->increments('favorite_id')->unsigned();
                $table->integer('user_id')->nullable();
                $table->integer('tile_id')->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
            });


	    /**
	     * Table: flagged
	     */
	    Schema::create('flagged', function($table) {
                $table->increments('flag_id')->unsigned();
                $table->integer('user_id')->nullable();
                $table->integer('tile_id')->nullable();
                $table->timestamp('flagged_date')->nullable()->default(NULL);;
            });


	    /**
	     * Table: follows
	     */
	    Schema::create('follows', function($table) {
                $table->increments('follow_id')->unsigned();
                $table->integer('user_id')->nullable();
                $table->integer('followed_user_id')->nullable();
                $table->integer('group_id')->nullable();
            });


	    /**
	     * Table: group_allowed_types
	     */
	    Schema::create('group_allowed_types', function($table) {
                $table->integer('hubgroup_id')->nullable();
                $table->integer('type_id')->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
            });


	    /**
	     * Table: group_focus
	     */
	    Schema::create('group_focus', function($table) {
                $table->increments('focus_id')->unsigned();
                $table->string('focus_name', 40);
            });


	    /**
	     * Table: group_invites
	     */
	    Schema::create('group_invites', function($table) {
                $table->increments('invite_id')->unsigned();
                $table->integer('hubgroup_id')->nullable();
                $table->string('email', 255)->nullable();
                $table->string('token', 255)->nullable();
                $table->boolean('is_admin');
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->dateTime('accepted_at')->nullable();
                $table->integer('invited_by')->nullable();
                $table->string('name', 100)->nullable();
            });


	    /**
	     * Table: hubgroups
	     */
	    Schema::create('hubgroups', function($table) {
                $table->increments('hubgroup_id')->unsigned();
                $table->string('name', 99);
                $table->integer('parent_id')->nullable();
                $table->text('about')->nullable();
                $table->string('location', 99)->nullable();
                $table->string('facebookURL', 255)->nullable();
                $table->string('twitterURL', 255)->nullable();
                $table->string('generalURL', 255)->nullable();
                $table->string('googlePlusURL', 255)->nullable();
                $table->string('pinterestURL', 255)->nullable();
                $table->string('youtubeURL', 255)->nullable();
                $table->string('otherURL', 255)->nullable();
                $table->integer('focusID')->nullable();
                $table->string('slug', 40);
                $table->string('group_type', 1)->default("O");
                $table->timestamp('created_at')->nullable()->nullable()->default(NULL);;
                $table->timestamp('updated_at')->nullable();
                $table->dateTime('deleted_at')->nullable();
                $table->string('user_id', 11)->nullable();
                $table->string('image', 20)->nullable();
                $table->decimal('latitude', 9,2)->nullable();
                $table->decimal('longitude', 9,2)->nullable();
                $table->integer('focus_id')->nullable();
                $table->string('cover_img', 100)->nullable();
                $table->string('profile_img', 100)->nullable();
                $table->boolean('upgraded_subdomain');
                $table->string('subdomain', 100)->nullable();
                $table->dateTime('subdomain_expires_at')->nullable();
                $table->boolean('upgraded_limittypes');
                $table->dateTime('limittypes_expires_at')->nullable();
                $table->string('welcome_text', 255)->nullable();
            });


	    /**
	     * Table: hubgroups_users
	     */
	    Schema::create('hubgroups_users', function($table) {
                $table->integer('user_id')->nullable();
                $table->integer('hubgroup_id')->nullable();
                $table->integer('is_admin');

            });


	    /**
	     * Table: ipn_order_item_options
	     */
	    Schema::create('ipn_order_item_options', function($table) {
                $table->increments('id')->unsigned();
                $table->integer('ipn_order_item_id');
                $table->string('option_name', 64)->nullable();
                $table->string('option_selection', 200)->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->timestamp('deleted_at')->nullable();
            });


	    /**
	     * Table: ipn_order_items
	     */
	    Schema::create('ipn_order_items', function($table) {
                $table->increments('id')->unsigned();
                $table->integer('ipn_order_id');
                $table->string('item_name', 127)->nullable();
                $table->string('item_number', 127)->nullable();
                $table->string('quantity', 127)->nullable();
                $table->decimal('mc_gross', 9,2)->nullable();
                $table->decimal('mc_handling', 9,2)->nullable();
                $table->decimal('mc_shipping', 9,2)->nullable();
                $table->decimal('tax', 9,2)->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->timestamp('deleted_at')->nullable();
            });


	    /**
	     * Table: ipn_orders
	     */
	    Schema::create('ipn_orders', function($table) {
                $table->increments('id')->unsigned();
                $table->string('notify_version', 64)->nullable();
                $table->string('verify_sign', 127)->nullable();
                $table->integer('test_ipn')->nullable();
                $table->string('protection_eligibility', 24)->nullable();
                $table->string('charset', 127)->nullable();
                $table->string('btn_id', 40)->nullable();
                $table->string('address_city', 40)->nullable();
                $table->string('address_country', 64)->nullable();
                $table->string('address_country_code', 2)->nullable();
                $table->string('address_name', 128)->nullable();
                $table->string('address_state', 40)->nullable();
                $table->string('address_status', 20)->nullable();
                $table->string('address_street', 200)->nullable();
                $table->string('address_zip', 20)->nullable();
                $table->string('first_name', 64)->nullable();
                $table->string('last_name', 64)->nullable();
                $table->string('payer_business_name', 127)->nullable();
                $table->string('payer_email', 127)->nullable();
                $table->string('payer_id', 13)->nullable();
                $table->string('payer_status', 20)->nullable();
                $table->string('contact_phone', 20)->nullable();
                $table->string('residence_country', 2)->nullable();
                $table->string('business', 127)->nullable();
                $table->string('receiver_email', 127)->nullable();
                $table->string('receiver_id', 64)->nullable();
                $table->string('custom', 255)->nullable();
                $table->string('invoice', 127)->nullable();
                $table->string('memo', 255)->nullable();
                $table->decimal('tax', 9,2)->nullable();
                $table->string('auth_id', 19)->nullable();
                $table->string('auth_exp', 28)->nullable();
                $table->decimal('auth_amount', 9,2)->nullable();
                $table->string('auth_status', 20)->nullable();
                $table->integer('num_cart_items')->nullable();
                $table->string('parent_txn_id', 19)->nullable();
                $table->string('payment_date', 28)->nullable();
                $table->string('payment_status', 20)->nullable();
                $table->string('payment_type', 10)->nullable();
                $table->string('pending_reason', 20)->nullable();
                $table->string('reason_code', 20)->nullable();
                $table->string('remaining_settle', 9)->nullable();
                $table->string('shipping_method', 64)->nullable();
                $table->string('shipping', 9)->nullable();
                $table->string('transaction_entity', 20)->nullable();
                $table->string('txn_id', 19)->nullable();
                $table->string('txn_type', 20)->nullable();
                $table->string('exchange_rate', 9)->nullable();
                $table->string('mc_currency', 3)->nullable();
                $table->string('mc_fee', 9)->nullable();
                $table->string('mc_gross', 9)->nullable();
                $table->string('mc_handling', 9)->nullable();
                $table->string('mc_shipping', 9)->nullable();
                $table->string('payment_fee', 9)->nullable();
                $table->string('payment_gross', 9)->nullable();
                $table->string('settle_amount', 9)->nullable();
                $table->string('settle_currency', 3)->nullable();
                $table->string('auction_buyer_id', 64)->nullable();
                $table->string('auction_closing_date', 28)->nullable();
                $table->integer('auction_multi_item')->nullable();
                $table->string('for_auction', 10)->nullable();
                $table->string('subscr_date', 28)->nullable();
                $table->string('subscr_effective', 28)->nullable();
                $table->string('period1', 10)->nullable();
                $table->string('period2', 10)->nullable();
                $table->string('period3', 10)->nullable();
                $table->decimal('amount1', 9,2)->nullable();
                $table->decimal('amount2', 9,2)->nullable();
                $table->decimal('amount3', 9,2)->nullable();
                $table->decimal('mc_amount1', 9,2)->nullable();
                $table->decimal('mc_amount2', 9,2)->nullable();
                $table->decimal('mc_amount3', 9,2)->nullable();
                $table->string('reattempt', 1)->nullable();
                $table->string('retry_at', 28)->nullable();
                $table->integer('recur_times')->nullable();
                $table->string('username', 64)->nullable();
                $table->string('password', 24)->nullable();
                $table->string('subscr_id', 19)->nullable();
                $table->string('case_id', 28)->nullable();
                $table->string('case_type', 28)->nullable();
                $table->string('case_creation_date', 28)->nullable();
                $table->string('order_status', 255)->nullable();
                $table->decimal('discount', 9,2)->nullable();
                $table->decimal('shipping_discount', 9,2)->nullable();
                $table->string('ipn_track_id', 127)->nullable();
                $table->string('transaction_subject', 255)->nullable();
                $table->text('full_ipn');
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->timestamp('deleted_at')->nullable();
            });


	    /**
	     * Table: media
	     */
	    Schema::create('media', function($table) {
                $table->increments('media_id')->unsigned();
                $table->integer('tile_id')->nullable();
                $table->string('filename', 50)->nullable();
                $table->string('filetype', 5)->nullable();
                $table->string('caption', 200)->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->boolean('resized');
            });


	    /**
	     * Table: messages
	     */
	    Schema::create('messages', function($table) {
                $table->increments('message_id')->unsigned();
                $table->integer('tile_id');
                $table->integer('message_parent_id')->nullable();
                $table->integer('sent_to');
                $table->integer('sent_by');
                $table->text('message')->nullable();
                $table->string('gift', 1)->nullable();
                $table->string('share', 1)->nullable();
                $table->string('borrow', 1)->nullable();
                $table->string('trade', 1)->nullable();
                $table->string('rent', 1)->nullable();
                $table->string('buy', 1)->nullable();
                $table->string('sell', 1)->nullable();
                $table->string('collaborate', 1)->nullable();
                $table->string('reuse', 1)->nullable();
                $table->string('open', 1)->nullable();
                $table->dateTime('sent_on')->nullable();
                $table->dateTime('read_on')->nullable();
                $table->decimal('amount', 8,2)->nullable();
            });


	    /**
	     * Table: search_history
	     */
	    Schema::create('search_history', function($table) {
                $table->string('post_type', 4)->nullable();
                $table->string('search', 255)->nullable();
                $table->string('listing_types', 255)->nullable();
                $table->string('location', 255)->nullable();
                $table->integer('user_id')->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
            });


	    /**
	     * Table: sitenews
	     */
	    Schema::create('sitenews', function($table) {
                $table->increments('id')->unsigned();
                $table->string('headline', 255)->nullable();
                $table->string('description', 255)->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
            });


	    /**
	     * Table: social
	     */
	    Schema::create('social', function($table) {
                $table->increments('id')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->string('service', 127);
                $table->string('uid', 127);
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->string('access_token', 255)->nullable();
                $table->integer('end_of_life')->nullable();
                $table->string('refresh_token', 255)->nullable();
                $table->string('request_token', 255)->nullable();
                $table->string('request_token_secret', 255)->nullable();
                $table->text('extra_params')->nullable();
                $table->string('access_token_secret', 255)->nullable();

            });


	    /**
	     * Table: tile_exchange_types
	     */
	    Schema::create('tile_exchange_types', function($table) {
                $table->increments('type_listing_id')->unsigned();
                $table->integer('type_id');
                $table->integer('tile_id');
            });


	    /**
	     * Table: tile_hubgroup_join
	     */
	    Schema::create('tile_hubgroup_join', function($table) {
                $table->increments('tile_hubgroups_id')->unsigned();
                $table->integer('hubgroup_id')->nullable();
                $table->integer('tile_id')->nullable();
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
            });


	    /**
	     * Table: tiles
	     */
	    Schema::create('tiles', function($table) {
                $table->increments('tile_id')->unsigned();
                $table->string('title', 255);
                $table->text('description')->nullable();
                $table->enum('post_type', array('want','have','whut'));
                $table->string('location', 255);
                $table->decimal('latitude', 9,2)->nullable();
                $table->decimal('longitude', 9,2)->nullable();
                $table->integer('user_id');
                $table->boolean('enabled')->default("1");
                $table->boolean('visible');
                $table->timestamp('created_at')->nullable()->default(NULL);
                $table->timestamp('updated_at')->nullable()->default(NULL);
                $table->timestamp('deleted_at')->nullable();
                $table->string('tags', 250)->nullable();
                $table->dateTime('expires')->nullable();
                $table->dateTime('completed_at')->nullable();

            });


         }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
         public function down()
         {

	            Schema::drop('activity_stream');
	            Schema::drop('exchange_types');
	            Schema::drop('favorites');
	            Schema::drop('flagged');
	            Schema::drop('follows');
	            Schema::drop('group_allowed_types');
	            Schema::drop('group_focus');
	            Schema::drop('group_invites');
	            Schema::drop('hubgroups');
	            Schema::drop('hubgroups_users');
	            Schema::drop('ipn_order_item_options');
	            Schema::drop('ipn_order_items');
	            Schema::drop('ipn_orders');
	            Schema::drop('media');
	            Schema::drop('messages');
	            Schema::drop('search_history');
	            Schema::drop('sitenews');
	            Schema::drop('social');
	            Schema::drop('tile_exchange_types');
	            Schema::drop('tile_hubgroup_join');
	            Schema::drop('tiles');
         }

}
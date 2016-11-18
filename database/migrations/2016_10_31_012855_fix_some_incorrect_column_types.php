<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixSomeIncorrectColumnTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('communities', function(Blueprint $table) {
            // created_by associates the community with a user_id
            $table->integer('created_by')->unsigned()->nullable()->default(NULL)->change();

            // Google Analytics ID's are 13 characters. Adding a bit more just in case
            $table->string('ga', 16)->nullable()->default(NULL)->change();

            // Probably should be theme_id but we can deal with that later. 
            // Let's at least make it a reasonable size
            $table->string('theme', 16)->nullable()->default('whitelabel')->change();

            // Logo should be the same length as the other images. 
            // 100 is reasonable in case we ever do absolute URLS
            $table->string('logo', 100)->nullable()->default(NULL)->change();

            // Add some indexes
            $table->index('parent_id');
            $table->index('group_type');
            $table->index('subdomain');
        });

        Schema::table('communities_users', function(Blueprint $table) {
            $table->unique(['user_id','community_id']);
            $table->index('is_admin');
        });

        Schema::table('community_allowed_types', function(Blueprint $table) {
            $table->index('community_id');
            $table->index('type_id');
        });

        Schema::table('community_join_requests', function(Blueprint $table) {
            $table->index('user_id');
            $table->index('community_id');
            $table->index('approved_by');
            $table->index('rejected_by');
        });

        Schema::table('community_user_invites', function(Blueprint $table) {
            $table->index('user_id');
            $table->index('admin_id');
            $table->index('community_id');
        });

        Schema::table('conversations', function(Blueprint $table) {
            $table->index('community_id');
            $table->index('entry_id');
            $table->index('started_by');
        });

        Schema::table('entries', function(Blueprint $table) {
            $table->index('post_type');
            $table->index('created_by');
            $table->index('enabled');
            $table->index('visible');
        });

        Schema::table('entries_community_join', function(Blueprint $table) {
            $table->unique(['community_id','entry_id']);
        });

        Schema::table('entries_exchange_types', function(Blueprint $table) {
            $table->unique(['type_id','entry_id']);
        });

        Schema::table('media', function(Blueprint $table) {
            $table->index('entry_id');
        });

        Schema::table('messages', function(Blueprint $table) {
            $table->index('sent_to');
            $table->index('sent_by');
            $table->index('thread_id');
        });

        Schema::table('stripe_subscriptions', function(Blueprint $table) {
            $table->index('community_id');
            $table->index('active');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('fb_url')->nullable()->default(NULL)->change();
            $table->string('twitter')->nullable()->default(NULL)->change();
            $table->string('pinterest')->nullable()->default(NULL)->change();
            $table->string('google')->nullable()->default(NULL)->change();
            $table->string('youtube')->nullable()->default(NULL)->change();

            // Add some indexes
            $table->index('slug');
            $table->index('superadmin');
            $table->index('verified');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function(Blueprint $table) {
            $table->string('created_by')->nullable()->default(NULL)->change();
            $table->dropIndex('communities_created_by_index');

            $table->text('ga')->nullable()->default(NULL)->change();

            $table->string('theme', 255)->nullable()->default('whitelabel')->change();

            $table->string('logo', 20)->nullable()->default(NULL)->change();

            $table->dropIndex('communities_parent_id_index');
            $table->dropIndex('communities_group_type_index');
            $table->dropIndex('communities_subdomain_index');
        });

        Schema::table('communities_users', function(Blueprint $table) {
            $table->dropIndex('communities_users_user_id_community_id_unique');
            $table->dropIndex('communities_users_is_admin_index');
        });

        Schema::table('community_allowed_types', function(Blueprint $table) {
            $table->dropIndex('community_allowed_types_community_id_index');
            $table->dropIndex('community_allowed_types_type_id_index');
        });

        Schema::table('community_join_requests', function(Blueprint $table) {
            $table->dropIndex('community_join_requests_user_id_index');
            $table->dropIndex('community_join_requests_community_id_index');
            $table->dropIndex('community_join_requests_approved_by_index');
            $table->dropIndex('community_join_requests_rejected_by_index');
        });

        Schema::table('community_user_invites', function(Blueprint $table) {
            $table->dropIndex('community_user_invites_user_id_index');
            $table->dropIndex('community_user_invites_community_id_index');
            $table->dropIndex('community_user_invites_admin_id_index');
        });


        Schema::table('conversations', function(Blueprint $table) {
            $table->dropIndex('conversations_community_id_index');
            $table->dropIndex('conversations_entry_id_index');
            $table->dropIndex('conversations_started_by_index');
        });

        Schema::table('entries', function(Blueprint $table) {
            $table->dropIndex('entries_post_type_index');
            $table->dropIndex('entries_created_by_index');
            $table->dropIndex('entries_enabled_index');
            $table->dropIndex('entries_visible_index');
        });

        Schema::table('entries_community_join', function(Blueprint $table) {
            $table->dropIndex('entries_community_join_community_id_entry_id_unique');
        });

        Schema::table('entries_exchange_types', function(Blueprint $table) {
            $table->dropIndex('entries_exchange_types_type_id_entry_id_unique');
        });

        Schema::table('media', function(Blueprint $table) {
            $table->dropIndex('media_entry_id_index');
        });

        Schema::table('messages', function(Blueprint $table) {
            $table->dropIndex('messages_sent_to_index');
            $table->dropIndex('messages_sent_by_index');
            $table->dropIndex('messages_thread_id_index');
        });

        Schema::table('stripe_subscriptions', function(Blueprint $table) {
            $table->dropIndex('stripe_subscriptions_community_id_index');
            $table->dropIndex('stripe_subscriptions_active_index');
        });

        Schema::table('users', function(Blueprint $table) {
            $table->string('fb_url', 100)->nullable()->default(NULL)->change();
            $table->string('twitter', 100)->nullable()->default(NULL)->change();
            $table->string('pinterest', 100)->nullable()->default(NULL)->change();
            $table->string('google', 100)->nullable()->default(NULL)->change();
            $table->string('youtube', 100)->nullable()->default(NULL)->change();
            $table->dropIndex('users_slug_index');
            $table->dropIndex('users_superadmin_index');
            $table->dropIndex('users_verified_index');
        });

    }
}

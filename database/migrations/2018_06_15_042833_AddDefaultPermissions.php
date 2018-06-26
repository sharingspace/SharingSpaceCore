<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            /*
         * Insert Default Permissions
         */
    
        DB::table('permissions')->insert([
            // Sharing Network
            [
                'name' => 'view-browse-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'edit-sharing-network-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view-about-permission',
                'guard_name' => 'web',
            ],

            // Members

            [
                'name' => 'view-members-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'request-membership-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'approve-new-member-permission',
                'guard_name' => 'web',
            ],

            // Entries

            [
                'name' => 'view-entry-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'post-entry-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'update-entry-permission',
                'guard_name' => 'web',
            ],

            //Community

            [
                'name' => 'join-community-permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'update-community-permission',
                'guard_name' => 'web',
            ],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            DB::table('permissions')->truncate();
        });
    }
}

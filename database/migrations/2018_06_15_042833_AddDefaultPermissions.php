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

            [
                'name' => 'edit-sharing-network-permission',
                'display_name' => 'Edit Sharing Network',
                'guard_name' => 'web',
                'order' => 1,
            ],

            // Members

            [
                'name' => 'view-members-permission',
                'display_name' => 'View members',
                'guard_name' => 'web',
                'order' => 2,
            ],

            [
                'name' => 'request-membership-permission',
                'display_name' => 'Request membership',
                'guard_name' => 'web',
                'order' => 3,
            ],

            [
                'name' => 'approve-new-member-permission',
                'display_name' => 'Approve new member',
                'guard_name' => 'web',
                'order' => 4,
            ],

            //Entries

            [
                'name' => 'edit-any-entry-permission',
                'display_name' => 'Edit any entry',
                'guard_name' => 'web',
                'order' => 5,
            ],

            [
                'name' => 'delete-any-entry-permission',
                'display_name' => 'Delete any entry',
                'guard_name' => 'web',
                'order' => 6,
            ],

            //Roles

            [
                'name' => 'manage-role',
                'display_name' => 'Manage role',
                'guard_name' => 'web',
                'order' => 7,
            ],

            [
                'name' => 'assign-role-permission',
                'display_name' => 'Assign role permission',
                'guard_name' => 'web',
                'order' => 8,
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
        DB::table('permissions')->truncate();
    }
}

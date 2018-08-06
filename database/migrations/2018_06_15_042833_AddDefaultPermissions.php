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

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('display_name')->after('name');
        });
        /*
         * Insert Default Permissions
         */
    
        DB::table('permissions')->insert([
            

            [
                'name' => 'edit-sharing-network-permission',
                'display_name' => 'Edit Sharing Network',
                'guard_name' => 'web',
            ],

            // Members

            [
                'name' => 'view-members-permission',
                'display_name' => 'View Members',
                'guard_name' => 'web',
            ],

            [
                'name' => 'request-membership-permission',
                'display_name' => 'Request Membership',
                'guard_name' => 'web',
            ],

            [
                'name' => 'approve-new-member-permission',
                'display_name' => 'Approve new member',
                'guard_name' => 'web',
            ],

            //Entries

            [
                'name' => 'edit-any-entry-permission',
                'display_name' => 'Edit any entry',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete-any-entry-permission',
                'display_name' => 'Delete any entry',
                'guard_name' => 'web',
            ],


            //Community

            [
                'name' => 'edit-community-permission',
                'display_name' => 'Edit community',
                'guard_name' => 'web',
            ],

            //Roles

            [
                'name' => 'create-role-permission',
                'display_name' => 'Create role',
                'guard_name' => 'web',
            ],

            [
                'name' => 'edit-role-permission',
                'display_name' => 'Edit role',
                'guard_name' => 'web',
            ],

            [
                'name' => 'delete-role-permission',
                'display_name' => 'Delete role',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view-role-permission',
                'display_name' => 'View role permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'assign-role-permission',
                'display_name' => 'Assign role permission',
                'guard_name' => 'web',
            ],

            [
                'name' => 'access-user-request-permission',
                'display_name' => 'Access user request permission',
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
        
    }
}

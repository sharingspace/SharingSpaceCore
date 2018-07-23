<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLayoutModeToCommunitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('permissions')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
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

        Schema::table('communities', function (Blueprint $table) {
            $table->enum('entry_layout', ['L', 'G', 'M'])->default('G')->after('show_info_bar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('communities', function (Blueprint $table) {
            $table->dropColumn('entry_layout');
        });
    }
}
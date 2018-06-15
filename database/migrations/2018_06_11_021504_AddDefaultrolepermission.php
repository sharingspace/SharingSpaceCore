<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDefaultrolepermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        /*
         * Insert Default Roles
         */
        DB::table('roles')->insert(['name' => 'Administrator','guard_name'=>'web']);
        DB::table('roles')->insert(['name' => 'Member','guard_name'=>'web']);
        DB::table('roles')->insert(['name' => 'Guest','guard_name'=>'web']);

        /*
         * Insert Default Permissions
         */
    
        DB::table('permissions')->insert([
            // Sharing Network
            [
                'name' => 'view-sharing-network',
                'guard_name' => 'web',
            ],

            [
                'name' => 'edit-sharing-network',
                'guard_name' => 'web',
            ],

            [
                'name' => 'view-about',
                'guard_name' => 'web',
            ],

            // Members

            [
                'name' => 'view-members',
                'guard_name' => 'web',
            ],

            [
                'name' => 'request-membership',
                'guard_name' => 'web',
            ],

            [
                'name' => 'approve-new-member',
                'guard_name' => 'web',
            ],

            // Entries

            [
                'name' => 'view-entry-detail',
                'guard_name' => 'web',
            ],

            [
                'name' => 'add-entry',
                'guard_name' => 'web',
            ],

            [
                'name' => 'edit-entry',
                'guard_name' => 'web',
            ],
        ]);

        foreach (DB::table('permissions')->get() as $key => $value) {
            DB::table('role_has_permissions')->insert([
                'permission_id' => $value->id,
                'role_id' => 1
            ]);
        }

        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_id' => 1,
            'model_type' => 'App\User'
        ]);
    }   

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}

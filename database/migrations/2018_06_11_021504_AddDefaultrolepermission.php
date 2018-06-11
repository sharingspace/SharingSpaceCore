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
            [
                'name' => 'view-sharing-network',
                'guard_name' => 'web',
            ]
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

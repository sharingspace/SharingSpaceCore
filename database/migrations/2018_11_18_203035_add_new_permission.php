<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;

class AddNewPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $role = Permission::where('order',7)->first();
        $role->update(['order' => 9]);

        $role = Permission::where('order',8)->first();
        $role->update(['order' => 10]);

        $role = Permission::where('order',5)->first();
        $role->update(['order' => 7]);
        
        $role = Permission::where('order',6)->first();
        $role->update(['order' => 8]);

        \DB::table('permissions')->insert([

            [
                'name' => 'add-entry-permission',
                'display_name' => 'Add entry',
                'guard_name' => 'web',
                'order' => 5,
            ],

            [
                'name' => 'view-entry-details-permission',
                'display_name' => 'View entry details',
                'guard_name' => 'web',
                'order' => 6,
            ]
        ]);

        $role = Permission::where('order',3)->first();
        $role->update(['name' => 'message-members-permission',
                       'display_name' => 'Message members'
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

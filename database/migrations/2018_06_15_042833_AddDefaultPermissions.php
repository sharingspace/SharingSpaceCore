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

<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class OpenClosedShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('communities')->insert([
            ['name' => 'Open Share', 'group_type' => 'O', 'subdomain' => 'openshare','theme' => 'whitelabel', 'show_info_bar' => 1, 'color' => 'black_white', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Closed Share', 'group_type' => 'C', 'subdomain' => 'closedshare','theme' => 'whitelabel', 'show_info_bar' => 1, 'color' => 'black_white', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'Secret Share', 'group_type' => 'S', 'subdomain' => 'secretshare','theme' => 'whitelabel', 'show_info_bar' => 1, 'color' => 'black_white', 'created_at' => Carbon::now()->format('Y-m-d H:i:s')]
        ]);
    }
}

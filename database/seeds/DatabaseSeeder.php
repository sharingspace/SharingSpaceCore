<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserSeeder::class);
        $this->call(CommunitySeeder::class);
        $this->call(EntrySeeder::class);
        $this->call(ExchangeTypeSeeder::class);
        $this->call(SuperAdminSeeder::class);
        Model::reguard();
    }
}

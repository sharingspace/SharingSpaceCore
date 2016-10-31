<?php

use Illuminate\Database\Seeder;
use App\ExchangeType;

class ExchangeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	ExchangeType::create(['name' => 'Buy/Sell']);
    	ExchangeType::create(['name' => 'Trade']);
    	ExchangeType::create(['name' => 'Gift']);
    	ExchangeType::create(['name' => 'Lend/Borrow']);
    	ExchangeType::create(['name' => 'Share']);
    	ExchangeType::create(['name' => 'Rent/Lease']);
    }
}

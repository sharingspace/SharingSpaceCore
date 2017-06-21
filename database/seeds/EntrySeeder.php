<?php
use Illuminate\Database\Seeder;
use App\Models\Entry;


class EntrySeeder extends Seeder
{
  public function run()
  {
      factory(Entry::class, 'entry', 25)->create()->each(function($u) {
          $u->exchangeTypes()->save(factory(\App\Models\Entry::class,'exchange-types')->make());
          $u->communities()->save(factory(\App\Models\Community::class, 'community')->make());
      });


  }
}

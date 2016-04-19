<?php
use Illuminate\Database\Seeder;
use App\Entry;


class EntrySeeder extends Seeder
{
  public function run()
  {
      factory(Entry::class, 'entry', 25)->create()->each(function($u) {
          $u->exchangeTypes()->save(factory(App\Entry::class,'exchange-types')->make());
          $u->communities()->save(factory(App\Community::class, 'community')->make());
      });


  }
}

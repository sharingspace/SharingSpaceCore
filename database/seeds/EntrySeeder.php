<?php
use Illuminate\Database\Seeder;
use App\Entry;


class EntrySeeder extends Seeder
{
  public function run()
  {
      factory(Entry::class, 'entry',25)->create();
  }
}

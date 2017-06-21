<?php
use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeeder extends Seeder
{
  public function run()
  {
    factory(User::class, 'user', 5)->create()->each(function($u) {
        $u->entries()->save(factory(\App\Models\Entry::class,'entry')->make());
        $u->communities()->save(factory(\App\Models\Community::class, 'community')->make());
    });
  }

}

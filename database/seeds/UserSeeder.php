<?php
use Illuminate\Database\Seeder;
use App\User;


class UserSeeder extends Seeder
{
  public function run()
  {
    factory(User::class, 'user', 5)->create()->each(function($u) {
        $u->entries()->save(factory(App\Entry::class,'entry')->make());
        $u->communities()->save(factory(App\Community::class, 'community')->make());
    });
  }

}

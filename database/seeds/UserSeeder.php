<?php
use Illuminate\Database\Seeder;
use App\User;


class UserSeeder extends Seeder
{
  public function run()
  {
      factory(User::class, 'user',25)->create();
  }
}

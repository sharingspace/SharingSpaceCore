<?php
use Illuminate\Database\Seeder;
use App\Community;


class CommunitySeeder extends Seeder
{
  public function run()
  {
      factory(Community::class, 'community',20)->create();
  }
}

<?php
// SuperAdminSeeder.php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

 
class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['first_name' => 'David', 'last_name' => 'Linnard', 'display_name' => 'David','email' => 'david@massmosaic.com', 'password' => bcrypt('secret'), 'superadmin' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['first_name' => 'Rob', 'last_name' => 'Jameson', 'display_name' => 'Ron','email' => 'rob@massmosaic.com', 'password' => bcrypt('secret'), 'superadmin' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['first_name' => 'Alison', 'last_name' => 'Gianotto', 'display_name' => 'Alison', 'email' => 'alison@massmosaic.com', 'password' => bcrypt('secret'), 'superadmin' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['first_name' => 'Eric', 'last_name' => 'Doriean', 'display_name' => 'Eric', 'email' => 'eric@massmosaic.com', 'password' => bcrypt('secret'), 'superadmin' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['first_name' => 'Vanderlei', 'last_name' => 'Amancia', 'display_name' => 'Harry', 'email' => 'harry@massmosaic.com', 'password' => bcrypt('secret'), 'superadmin' => 1, 'created_at' => Carbon::now()->format('Y-m-d H:i:s')]
        ]);
    }
}


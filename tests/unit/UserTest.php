<?php
use App\User;
use Illuminate\Support\Facades\Hash;
class UserTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    public function testRegister()
    {
        $email = 'johndoe@example.com';
        $password = Hash::make('password');
        $first_name = 'John';
        $last_name = 'Doe';
        User::register(['email' => $email, 'password' => $password, 'first_name' => $first_name, 'last_name' => $last_name]);
        $this->tester->seeRecord('users', [
          'email' => $email,
          'password' => $password,
          'first_name' => $first_name,
          'last_name' => $last_name
        ]);
    }
}

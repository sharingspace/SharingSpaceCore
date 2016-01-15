<?php
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testRegister()
    {
        $user = factory(App\User::class, 'user')->make();
        $values = [
          'email' => $user->email,
          'password' => $user->password,
          'first_name' => $user->first_name,
          'last_name' => $user->last_name
        ];
        User::register($values);
        $this->tester->seeRecord('users', $values);
    }
}

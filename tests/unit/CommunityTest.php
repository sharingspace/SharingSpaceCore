<?php
use App\Models\Community;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommunityTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testNewCommunity()
    {
        $community = factory(\App\Models\Community::class, 'community')->make();
        $values = [
          'name' => $community->name,
          'subdomain' => $community->subdomain,
          'group_type' => $community->group_type,
        ];

        Community::create($values);
        $this->tester->seeRecord('communities', $values);
    }
}

<?php
use App\Models\Entry;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EntryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testNewWantEntry()
    {
        $entry = factory(\App\Models\Entry::class, 'want-entry')->make();
        $values = [
          'title' => $entry->title,
          'post_type' => $entry->post_type,
          'qty' => $entry->qty,
        ];

        Entry::create($values);
        $this->tester->seeRecord('entries', $values);
    }

    public function testNewHaveEntry()
    {
        $entry = factory(\App\Models\Entry::class, 'have-entry')->make();
        $values = [
          'title' => $entry->title,
          'post_type' => $entry->post_type,
          'qty' => $entry->qty,
        ];

        Entry::create($values);
        $this->tester->seeRecord('entries', $values);
    }
}

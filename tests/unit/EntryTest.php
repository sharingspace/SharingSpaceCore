<?php
use App\Entry;
use Illuminate\Support\Facades\Hash;
class EntryTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    public function testNewEntry()
    {
        $title = 'This is a test entry';
        $post_type = 'want';

        Entry::create(['title' => $title, 'post_type' => $post_type]);
        $this->tester->seeRecord('entries', [
          'title' => $title,
          'post_type' => $post_type,
        ]);
    }
}

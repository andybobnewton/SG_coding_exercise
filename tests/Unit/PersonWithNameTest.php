<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\HomeOwner;

class PersonWithNameTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_single_person_parsing()
    {
        $result = HomeOwner::create_from_csv_row(['Mr John Smith']);

        $home_owners = $result['result'];
        $this->assertEquals(count($home_owners), 1);
        $home_owner = $home_owners[0];
        
        $this->assertEquals($home_owner->first_name, 'John');
        $this->assertEquals($home_owner->last_name, 'Smith');
        $this->assertEquals($home_owner->initial, null);
        $this->assertEquals($home_owner->title, 'Mr');
    }
}

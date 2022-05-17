<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Person;

class PersonWithInitialTest extends TestCase
{
    /**
     * Unit test - import single person with initial first name.
     *
     * @return void
     */
    public function test_import_initial_person()
    {
        $result = Person::create_from_csv_row(['Mrs J. Smith']);
        $home_owners = $result['result'];
        $this->assertEquals(count($home_owners), 1);
        $home_owner = $home_owners[0];
        $this->assertEquals($home_owner->first_name, null);
        $this->assertEquals($home_owner->last_name, 'Smith');
        $this->assertEquals($home_owner->initial, 'J');
        $this->assertEquals($home_owner->title, 'Mrs');
    }
}

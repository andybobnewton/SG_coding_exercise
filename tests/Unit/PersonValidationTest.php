<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Person;

class PersonValidationTest extends TestCase
{
    /**
     * Unit test - import single person with initial first name.
     *
     * @return void
     */
    public function test_import_initial_person()
    {
        $result = Person::create_from_csv_row(['test']);
        $home_owners = $result['result'];
        $error = $result['error'];
        $this->assertEquals($error, "Invalid row");
        $home_owner = $home_owners[0];
        $this->assertEquals(
            $home_owner->validation_errors->get('*')['last_name'][0],
            "The last name field is required."
        );
    }
}

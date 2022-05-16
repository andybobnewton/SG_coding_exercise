<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\HomeOwner;

class TwoPersonTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_importing_two_people_single_row()
    {
        $result = HomeOwner::create_from_csv_row(['Mrs & Mr Smith']);

        $home_owners = $result['result'];
        $this->assertEquals(count($home_owners), 2);
        $home_owner_1 = $home_owners[0];

        $home_owner_2 = $home_owners[1];
        $this->assertEquals($home_owner_1->first_name, null);
        $this->assertEquals($home_owner_1->last_name, 'Smith');
        $this->assertEquals($home_owner_1->initial, null);
        $this->assertEquals($home_owner_1->title, 'Mr');


        $this->assertEquals($home_owner_2->first_name, null);
        $this->assertEquals($home_owner_2->last_name, 'Smith');
        $this->assertEquals($home_owner_2->initial, null);
        $this->assertEquals($home_owner_2->title, 'Mrs');
    }
}

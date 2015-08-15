<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \Wolphy\Appointment;
use \Wolphy\Client;
use \Faker\Generator;

class AppointmentTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

    }

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testOnDeleteClientAppointmentsAlsoDeleted()
    {
        $client = factory(Client::class)->make();
        $client->user_id = 1;
        $client->save();

        $appointments = factory(Appointment::class,2)->make()
                                                     ->each(function($a) use($client) {
                                                         $a->client_id=$client->id;
                                                         $a->save();
                                                     });

        $this->assertEquals(2,$client->appointments()->count());

        //now delete client

        $client->delete();

        $appointments_count = Appointment::count();
        $this->assertEquals(0,$appointments_count);

    }
}

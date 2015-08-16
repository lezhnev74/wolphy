<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \Wolphy\Appointment;
use \Wolphy\Client;
use \Faker\Generator;
use Carbon\Carbon;

class AppointmentTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp() {
        parent::setUp();

        \DB::enableQueryLog();
    }

    /**
     * Test that when Client is deleted - all his appointments are deleted also
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

        $client->delete();

        $appointments_count = Appointment::count();
        $this->assertEquals(0,$appointments_count);

    }

    /**
     * Test that scope with dates is working
     */
    public function testScopeDates() {


        $client = factory(Client::class)->make();
        $client->user_id = 1;
        $client->save();

        $appointments = factory(Appointment::class,2)->make()
            ->each(function($a) use($client) {
                $a->client_id=$client->id;
                $a->save();
            });

        $appointments[0]->datetime = date('Y-m-d 12:00:01');
        $appointments[1]->datetime = date('Y-m-d',strtotime("+1 week"));

        $appointments[0]->save();
        $appointments[1]->save();

        $this->assertEquals(2, Appointment::count());

        $this->assertEquals(1, Appointment::today()->count());

        $this->assertEquals(1,
                Appointment::dates(
                    date("Y-m-d 00:00:01",strtotime("+2 days")) ,
                    date("Y-m-d 00:00:01",strtotime("+9 days"))
                )
             ->count());

        $this->assertEquals(0 , Appointment::dates( date("Y-m-d 00:00:01" , strtotime("+8 days") ) )->count());

    }


}

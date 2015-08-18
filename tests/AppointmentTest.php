<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use \Wolphy\Appointment;
use \Wolphy\Client;
use Wolphy\ClientRepository;
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

    /**
     * This tests show that getCold method works as expected and returns Client's Collection
     */
    public function testGettingColdUsers() {
        $client = factory(Client::class)->make();
        $client->user_id = 1;
        $client->save();

        $client2 = factory(Client::class)->make();
        $client2->user_id = 1;
        $client2->phone = '1';
        $client2->email = 'a@a.com';
        $client2->save();

        //appointments for client1

        $appointments = factory(Appointment::class,3)->make()
            ->each(function($a) use($client) {
                $a->client_id=$client->id;
                $a->save();
            });

        $appointments[0]->datetime = date('2012-01-01 12:00:01');
        $appointments[1]->datetime = date('2012-06-01 12:00:01');
        $appointments[2]->datetime = date('2012-12-01 12:00:01');

        $appointments[0]->save();
        $appointments[1]->save();
        $appointments[2]->save();

        //appointments for client2

        $appointments = factory(Appointment::class,3)->make()
            ->each(function($a) use($client2) {
                $a->client_id=$client2->id;
                $a->save();
            });

        $appointments[0]->datetime = date('2012-02-01 12:00:01');
        $appointments[1]->datetime = date('2012-07-01 12:00:01');
        $appointments[2]->datetime = date('2012-11-01 12:00:01');

        $appointments[0]->save();
        $appointments[1]->save();
        $appointments[2]->save();

        $this->assertEquals(0, Client::getCold( "2012-12-02 00:00:01" )->count() );
        $this->assertEquals(2, Client::getCold( "2012-10-02 00:00:01" )->count() );

    }


}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call(UserTableSeeder::class);

        $faker = Faker\Factory::create();

        //Create a few fake clients and appointments
        for($i=0;$i<4;$i++) {
            $client = new Wolphy\Client();
            $client->account_id = 1;
            $client->first_name = $faker->firstName;
            $client->last_name = $faker->lastName;
            $client->email = $faker->email;
            $client->phone = $faker->phoneNumber;
            $client->save();

            for($j=0;$j<rand(1,3);$j++) {
                $appointment = new Wolphy\Appointment();
                $appointment->client_id = $client->id;
                $appointment->datetime = $faker->dateTime;
                $appointment->save();
            }
        };



        Model::reguard();
    }
}

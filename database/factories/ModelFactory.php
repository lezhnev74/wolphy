<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(Wolphy\Client::class, function ($faker) {
    return [
        'first_name' => $faker->name,
        'email' => $faker->email,
        'birthdate'=>$faker->date
    ];
});

$factory->define(Wolphy\Appointment::class, function ($faker) {
    return [
        'duration_minutes'=>$faker->numberBetween(60,120),
        'datetime'=>$faker->dateTime
    ];
});
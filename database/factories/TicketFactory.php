<?php

use Carbon\Carbon;
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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Ticket::class, function (Faker\Generator $faker) {
    return [
        'customer_id' => $faker->numberBetween($min=1, $max=10),
        'created_at' => Carbon::now()->subMinutes(rand(1, 200)),
        'updated_at' => Carbon::now()->addMinutes(rand(1, 200))
    ];
});

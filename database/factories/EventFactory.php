<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use App\Tour;
use App\Event;
use App\Venue;
use App\Accomadation;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
	$users = User::pluck('id')->toArray();
	$tours = Tour::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($users),
        'tour_id' => $faker->randomElement($tours),
        'date' => $faker->date(),
        'time' => $faker->time(),
        'set_length' => $faker->numberBetween(0, 90),
        'venue_id' => factory(Venue::class)->create(),
        'accomadation_id' => factory(Accomadation::class)->create(),
        'rider' => $faker->sentence(),
        'pay' => $faker->numberBetween(350, 800)
    ];
});

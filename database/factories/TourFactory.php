<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Tour;
use App\User;
use Faker\Generator as Faker;

$factory->define(Tour::class, function (Faker $faker) {
	$users = User::pluck('id')->toArray();
    return [
        'user_id' => $faker->randomElement($users),
        'name' => $faker->word(),
        'fuel' => $faker->numberBetween(200, 350)
    ];
});

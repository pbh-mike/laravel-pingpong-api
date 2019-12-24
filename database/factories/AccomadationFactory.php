<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Accomadation;
use App\Address;
use Faker\Generator as Faker;

$factory->define(Accomadation::class, function (Faker $faker) {
    return [
		'name' => $faker->word(),
		'cost' => $faker->numberBetween(0, 150),
		'address_id' => factory(App\Address::class)->create(), // $faker->(), 
		'check_in' => $faker->time(),
		'check_out' => $faker->time()
    ];
});

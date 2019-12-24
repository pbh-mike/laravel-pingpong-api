<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Venue;
use App\Address;
use Faker\Generator as Faker;

$factory->define(Venue::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'type' => $faker->word(),
        'address_id' => factory(App\Address::class)->create()
    ];
});

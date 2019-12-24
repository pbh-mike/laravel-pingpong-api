<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'name' => $faker->word(),
        'address_line_one' => $faker->streetAddress(),
        'postcode' => $faker->postcode(),
        'lat' => $faker->latitude(),
        'lng' => $faker->longitude()
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(\App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Resound', 'Unitron', 'Signia', 'Phonak', 'Starkey']),
        'quantity' => $faker->randomDigit,
        'price' => $faker->randomNumber(2),
        'tax' => $faker->numberBetween(2, 5),
    ];
});

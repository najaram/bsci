<?php

use Faker\Generator as Faker;

$factory->define(\App\Invoice::class, function (Faker $faker) {
    return [
        'customer_name'    => $faker->name,
        'customer_address' => $faker->address,
        'invoice_date'     => \Carbon\Carbon::now()->format('Y-m-d'),
        'invoice_number'   => $faker->randomDigit,
        'invoice_due_date' => \Carbon\Carbon::now()->format('Y-m-d'),
        'invoice_note'     => $faker->text,
        'product_name'     => $faker->randomElement(['Resound', 'Unitron', 'Signia', 'Phonak', 'Starkey']),
        'product_qty'      => $faker->randomDigit,
        'product_price'    => $faker->randomNumber(2),
        'product_tax'      => $faker->numberBetween(2, 5),
        'payment_type'     => $faker->randomElement(['cash', 'check', 'credit']),
        'payment_amount'   => $faker->randomNumber(3),
    ];
});

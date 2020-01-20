<?php

use Faker\Generator as Faker;
use App\Models\Contact;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'name'          => $faker->unique()->word,
        'email'         => $faker->unique()->safeEmail,
        'telefone'      => $faker->unique()->phoneNumber,
        'site'          => $faker->unique()->url,
    ];
});

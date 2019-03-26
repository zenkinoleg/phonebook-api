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

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
    ];
});

$factory->define(App\Models\Phonebook::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
		'phone_number' => '+'.mt_rand(10,99).' '.mt_rand(1e2,1e3-1).' '.mt_rand(1e8,1e9-1),
		'country' => 'RU',
		'timezone' => 'Europe/Moscow',
    ];
});


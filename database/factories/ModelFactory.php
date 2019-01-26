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

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
		'username' => $faker->unique()->username,
		'email' => $faker->unique()->email,
        'user_type' => 'WRITER',
        'active' => 1,
		'balance' => 0,
		'orders_complete' => rand(0, 150),
		'password' => bcrypt('writer'),
		'created_at' => \Carbon\Carbon::now(),
		'updated_at' => \Carbon\Carbon::now(),
		'last_seen'  => \Carbon\Carbon::now(),
    ];
});

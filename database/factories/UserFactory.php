<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Features\Users\Models\User::class, function (Faker $faker) {
    return [
        'id'                => Str::uuid(),
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => bcrypt("password"), // password
        'remember_token'    => Str::random(10),
        'phone'             => "".rand(1000000000, 9999999999),
        'sid'               => App\Features\Users\Models\User::generateSid()
    ];
});

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

$factory->define(App\Features\Marketplace\Models\Coupon::class, function (Faker $faker) {
    return [
        'id'                => Str::uuid(),
        "coupon_code"       => Str::random(),
        "coupon_type"       => rand(0,1),
        "upper_limit"       => rand(80, 120),
        "minimum_cart_value"=> rand(150, 300),
        "max_count"         => rand(7, 15),
    ];
});

<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(App\Features\Courses\Models\Course::class, function (Faker $faker) {
    return [
        'id'            => Str::uuid(),
        'valid_till'    => \Carbon\Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
        'name'          => $faker->slug,
        'price'         => rand(50, 400),
        'created_at'    => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'file_urls'     => json_encode(["urls"=>[]])
    ];
});

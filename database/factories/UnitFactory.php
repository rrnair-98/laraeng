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

$factory->define(App\Features\Courses\Models\Unit::class, function (Faker $faker) {
    $isScheduled = rand(0,1);
    return [
        'id'            => Str::uuid(),
        'unit_name'     => $faker->slug,
        'created_at'    => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
        'is_scheduled'  => $isScheduled,
        'start_date'    => $isScheduled ? \Carbon\Carbon::now()->addDays(4)->format('Y-m-d H:i:s'): null,
        'duration'      => rand(60, 120),
        'is_draft'      => rand(0,1),
        'file_urls'     => json_encode(["urls"=>[]]),
        'marks'         => rand(10, 30),
    ];
});

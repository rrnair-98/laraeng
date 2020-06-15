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

$factory->define(App\Features\Marketplace\Models\CartCourse::class, function (Faker $faker) {
    $course = App\Features\Courses\Models\Course::inRandomOrder()->first();
    // todo add coupon id here for discount
    //$coupon = rand(0, 1) ? : null;
    return [
        'id'            => Str::uuid(),
        "course_id"     => $course->id,
        "valid_till"    => $course->valid_till,
        "cost_price"    => $course->price,
    ];
});

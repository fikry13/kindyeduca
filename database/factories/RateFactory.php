<?php

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

$factory->define(App\Models\Rate::class, function (Faker $faker) {
    $students = \App\Models\User::role('student')->pluck('id');
    $teachers = \App\Models\User::role('teacher')->pluck('id');

    return [
        'student_id' => $students->random(),
        'teacher_id' => $teachers->random(),
        'rate'=> $faker->numberBetween(0,4),
        'comment' => $faker->realText()
    ];
});

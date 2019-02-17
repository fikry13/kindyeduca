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
$factory->define(App\Models\Session::class, function (Faker $faker) {
    $student = \App\Models\BackpackUser::role('student')->get()->random();
    $teachers = \App\Models\BackpackUser::role('teacher')->pluck('id');
    $subject = \App\Models\Grade::find($student->grade_id)->subjects->random();
    return [
        'student_id'=>$student->id,
        'teacher_id'=>$teachers->random(),
        'subject_id'=>$subject->id,
        'gender_preference' => $faker->numberBetween(0,2),
        'day' => $faker->numberBetween(0,7),
        'time' => $faker->time()
    ];
});

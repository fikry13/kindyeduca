<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 22.34
 */

use App\Models\Subject;

class SubjectsTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $subjects = factory(Subject::class, 25)->create();

        $grades = \App\Models\Grade::all();

        foreach ($grades as $grade)
        {
            $grade->subjects()->sync($subjects->random(5));
        }
    }
}
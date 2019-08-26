<?php

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use App\User;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'owner', 'guard_name' => 'web']);
        Role::create(['name' => 'teacher', 'guard_name' => 'web']);
        Role::create(['name' => 'student', 'guard_name' => 'web']);

        $sd = \App\Models\School::create(['name' => 'SD', 'color' => '#ce1c1c']);
        $smp = \App\Models\School::create(['name' => 'SMP', 'color' => '#00095b']);
        $sma = \App\Models\School::create(['name' => 'SMA', 'color' => '#7f88db']);
        $lain = \App\Models\School::create(['name' => 'Lain-lain', 'color' => '#565656']);

        Grade::create(['school_id' => $sd->id, 'grade'=> 'Kelas 1']);
        Grade::create(['school_id' => $sd->id, 'grade'=> 'Kelas 2']);
        Grade::create(['school_id' => $sd->id, 'grade'=> 'Kelas 3']);
        Grade::create(['school_id' => $sd->id, 'grade'=> 'Kelas 4']);
        Grade::create(['school_id' => $sd->id, 'grade'=> 'Kelas 5']);
        Grade::create(['school_id' => $sd->id, 'grade'=> 'Kelas 6']);

        Grade::create(['school_id' => $smp->id, 'grade'=> 'Kelas 7']);
        Grade::create(['school_id' => $smp->id, 'grade'=> 'Kelas 8']);
        Grade::create(['school_id' => $smp->id, 'grade'=> 'Kelas 9']);

        Grade::create(['school_id' => $sma->id, 'grade'=> 'Kelas 10']);
        Grade::create(['school_id' => $sma->id, 'grade'=> 'Kelas 11']);
        Grade::create(['school_id' => $sma->id, 'grade'=> 'Kelas 12']);

        Grade::create(['school_id' => $lain->id, 'grade'=> 'Lain-lain']);

        //$subjects = factory(Subject::class, 25)->create();

        Subject::create(['name' => 'Matematika', 'color' => '#f5bf42']);
        Subject::create(['name' => 'Kimia', 'color' => '#c533ff']);
        Subject::create(['name' => 'Fisika', 'color' => '#0579f5']);
        Subject::create(['name' => 'Biologi', 'color' => '#47b329']);
        Subject::create(['name' => 'IPA', 'color' => '#7d0000']);

        $subjects = Subject::all();

        $grades = \App\Models\Grade::all();

        foreach ($grades as $grade)
        {
            $grade->subjects()->sync($subjects->random(5));
        }

        $admin = \App\Models\BackpackUser::create(
            [
                "name" => "Fikry Abdullah Aziz",
                "email" => "fikry13@gmail.com",
                "password" => bcrypt('13121994'),
                "verified" => 1
            ]
        );
        $admin->assignRole('admin');
        $admin->save();

        $owner = \App\Models\BackpackUser::create(
            [
                "name" => "Admin",
                "email" => "admin@kindyeduca.net",
                "password" => bcrypt('k1ndyEduc4'),
                "verified" => 1
            ]
        );
        $owner->assignRole('owner');
        $owner->save();

        $grades = \App\Models\Grade::all()->pluck('id');

        $teacher = \App\Models\BackpackUser::create(
            [
                "name" => "Teacher",
                "email" => "teacher@kindyeduca.net",
                "password" => bcrypt('teacher'),
                "grade_id" => $grades->random(),
                "verified" => 0
            ]
        );
        $teacher->assignRole('teacher');
        $teacher->save();

        $preference = \App\Models\TeacherPreference::firstOrCreate(['teacher_id' => $teacher->id]);

        $student = \App\Models\BackpackUser::create(
            [
                "name" => "Student",
                "email" => "student@kindyeduca.net",
                "password" => bcrypt('student'),
                "grade_id" => $grades->random(),
                "verified" => 0
            ]
        );
        $student->assignRole('student');
        $student->save();

        Storage::disk('public')->deleteDirectory('avatar');
        Storage::disk('public')->makeDirectory('avatar');

//        factory(App\User::class, 100)->create();
//        $users = \App\Models\BackpackUser::all();
//        $subjects = \App\Models\Subject::all();
//        foreach ($users as $user)
//        {
//            if(!$user->hasAnyRole(['admin', 'owner', 'teacher', 'student']))
//            {
//                if(rand(0,2)>0)
//                    $user->assignRole('student');
//                else
//                {
//                    $user->assignRole('teacher');
//
//                    $preference = \App\Models\TeacherPreference::firstOrCreate(['teacher_id' => $user->id]);
//                }
//            }
//
//            if(!is_dir(storage_path('app/public/avatar/'.$user->id)))
//                Storage::disk('avatar')->makeDirectory($user->id);
//            $user->avatar = Faker::create()->image(storage_path('app/public/avatar/'.$user->id), 300, 300, null, false);
//
//            $user->skills()->sync($subjects->random(5));
//            $user->save();
//        }
//
//        $preferences = \App\Models\TeacherPreference::all();
//
//        foreach ($preferences as $preference)
//        {
//            $preference->grades()->sync($grades->random(3));
//            $preference->save();
//        }
//
//        $sessions = factory(\App\Models\Session::class, 200)->create();

    }
}

<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 19.51
 */

use Illuminate\Database\Seeder;
use App\User;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        Storage::deleteDirectory('public\\avatars');

        $faker = Faker::create();
        factory(User::class, 1)->create();
        $admin = User::all()->first();
        $admin->name = 'Admin';
        $admin->email = 'admin@kindyeduca.net';
        $admin->password = bcrypt('k1ndyEduc4');
        $admin->assignRole('admin');
        $admin->save();

        factory(App\User::class, 100)->create();
        $users = \App\User::all();
        $subjects = \App\Models\Subject::all();
        foreach ($users as $user)
        {
            $user->clearMediaCollection();

            if($user->gender == 0)
                $user->addMediaFromUrl(asset('demo/user_man.jpg'))
                    ->toMediaCollection();
            else
                $user->addMediaFromUrl(asset('demo/user_woman.jpg'))
                    ->toMediaCollection();

            if(rand(0,2)>0)
                $user->assignRole('student');
            else
                $user->assignRole('teacher');

            $user->skills()->sync($subjects->random(5));
            $user->save();
        }
    }
}
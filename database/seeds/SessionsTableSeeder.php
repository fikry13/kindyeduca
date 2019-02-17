<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 20/06/2018
 * Time: 06.52
 */

class SessionsTableSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        $sessions = factory(\App\Models\Session::class, 200)->create();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 19.51
 */

use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradesTableSeeder extends Seeder
{
    public function run()
    {
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
    }
}
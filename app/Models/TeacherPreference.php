<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 07.25
 */

namespace App\Models;

use App\User;
use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\Model;

class TeacherPreference extends Model
{
    protected $fillable =
        [
            'teacher_id', 'gender', 'days', 'times', 'radius'
        ];


    public function teacher()
    {
        return $this->belongsTo(User::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grades_preferences', 'teacher_preference_id', 'grade_id');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 07.25
 */

namespace App\Models;


use Hootlex\Moderation\Moderatable;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use Moderatable;

    protected $fillable =
        [
            'student_id','teacher_id', 'subjects_id', 'grades_id', 'gender_preference'
        ];


    public function teacher()
    {
        return $this->hasOne(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->hasOne(User::class, 'student_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class);
    }
}
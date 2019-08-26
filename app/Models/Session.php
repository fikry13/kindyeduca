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

class Session extends Model
{
    use Moderatable;

    protected $fillable =
        [
            'student_id','teacher_id', 'subject_id', 'gender_preference', 'day', 'time'
        ];


    public function teacher()
    {
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function student()
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function subject()
    {
        return $this->hasOne(Subject::class, 'id', 'subject_id');
    }
}
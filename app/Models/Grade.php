<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 08.24
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable =
        ['school_id','grade'];

    public function users()
    {
        return $this->hasMany(User::class );
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'grade_subjects', 'grade_id', 'subject_id');
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function inPreferences()
    {
        return $this->belongsToMany(TeacherPreference::class, 'grade_preferences', 'grade_id', 'preference_id');
    }


}
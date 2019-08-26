<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 08.04
 */

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable =
        ['name', 'color'];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'grade_subjects', 'subject_id', 'grade_id');
    }

    public function masters()
    {
        return $this->belongsToMany(User::class, 'skills', 'subject_id', 'teacher_id');
    }
}
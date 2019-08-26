<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 10.01
 */

namespace App\Models;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{

    protected $fillable =
        ['student_id', 'teacher_id', 'rate', 'comment'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
<?php

namespace App;

use App\Models\Grade;
use App\Models\Rate;
use App\Models\Session;
use App\Models\Subject;
use App\Models\TeacherPreference;
use Backpack\CRUD\CrudTrait;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use CrudTrait;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'latitude', 'longitude', 'gender', 'age', 'phone', 'address', 'description', 'grade_id', 'verified'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function joinedSessions()
    {
        return $this->hasMany(Session::class, 'student_id');
    }

    public function teachingSessions()
    {
        return $this->hasMany(Session::class, 'teacher_id');
    }

    public function sendRates()
    {
        return $this->hasMany(Rate::class, 'user_id');
    }

    public function receivedRates()
    {
        return $this->hasMany(Rate::class, 'teacher_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Subject::class, 'skills', 'teacher_id', 'subject_id');
    }

    public function getAvatarUrlAttribute()
    {
        $str = $this->avatar;
        if(!isset($str) || trim($str) === '')
            return url('/img/default-avatar.png');
        else
            return Storage::disk('avatar')->url($this->id."/".$this->avatar);
    }

    public function preference()
    {
        return $this->hasOne(TeacherPreference::class, 'teacher_id', 'id');
    }

    public function verify()
    {
        $this->verified = 1;
        $this->save();
    }

    public function unverify()
    {
        $this->verified = 0;
        $this->save();
    }
}

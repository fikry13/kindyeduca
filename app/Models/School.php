<?php
/**
 * Created by PhpStorm.
 * User: arcom
 * Date: 19/06/2018
 * Time: 20.16
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name', 'color'];

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}
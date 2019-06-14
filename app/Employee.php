<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $table='employees';


    public function reports(){
        return $this->hasMany(Report::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    //
    protected $fillable=['description','date','employee_id'];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }
}

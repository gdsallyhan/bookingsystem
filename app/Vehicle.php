<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle extends Model
{
    use SoftDeletes;
    
    public function customer(){

        return $this->belongsTo('App\Customer')->first();

    }


     public function booking(){

        return $this->belongsTo('App\Booking')->first();

    }

    public function model(){

        return $this->belongsTo('App\ModelVehicle','id')->first();
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelVehicle extends Model
{
    use SoftDeletes;
    
    public function customer(){

        return $this->belongsTo('App\Customer')->first();

    }
     public function booking(){

        return $this->belongsTo('App\Booking')->first();

    }
    public function vehicle(){

        return $this->belongsTo('App\Vehicle', 'id')->withTrashed()->first();
    }
}

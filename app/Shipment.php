<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
//

class Shipment extends Model
{
    //use HasFactory;
 
    public function locationPickup(){
        return $this->hasMany('App\Location', 'port_to');
    }


    public function locationDelivery(){
        return $this->hasMany('App\Location', 'port_from');
    }
}

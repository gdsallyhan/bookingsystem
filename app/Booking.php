<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{

    use SoftDeletes;

    public function customer(){

        return $this->belongsTo('App\Customer')->withTrashed()->first();

    }

    public function shipment(){

        return $this->belongsTo('App\Shipment')->first();

    }

     public function locationPickup(){

        return $this->belongsTo('App\Location', 'location_id_pickup')->withTrashed()->first();

    }

    public function locationDelivery(){

        return $this->belongsTo('App\Location', 'location_id_delivery')->withTrashed()->first();

    }

    public function vehicle(){

        return $this->belongsTo('App\Vehicle', 'id')->withTrashed()->first();
    }

     public function user(){

        return $this->belongsTo('App\User')->first();
    }

     public function package(){

        return $this->belongsTo('App\Package')->first();
    }

    public function insurance(){

        return $this->belongsTo('App\Insurance')->withTrashed()->first();
    }

    public function model(){

        return $this->belongsTo('App\ModelVehicle','id')->first();
    }
}

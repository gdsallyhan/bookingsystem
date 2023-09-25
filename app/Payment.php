<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
  protected $fillable = [
    'customer_id',
    'booking_id',
    'mode',
    'amount',
    'status',
    'ref',
    'receipt',
    'payment_date',
    'payment_time',
  ];

      public function customer(){

        return $this->belongsTo('App\Customer', 'customer_id')->first();

    }

     public function booking(){

        return $this->belongsTo('App\Booking','booking_id')->first();

    }


}

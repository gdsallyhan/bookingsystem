<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Booking;
use App\Shipment;
use App\Vehicle;
use App\Location;
use App\Customer;
use App\Package;
use App\Insurance;
use App\ModelVehicle;

class DropdownController extends Controller
{
    public function fetchTrips($tId)
    {
        $pack_car = $tId;

        $trips = Package::select('id','trip_from','trip_to','price')
                                    ->where('car_category', $pack_car)
                                    ->get();

        //return $trips;

        $trip_array = array();
        $trip_ship_array = array();

        for($i = 0; $i < count($trips); $i++){

               $trip_ship_array['trip_id'] = $trips[$i]->id;
               $trip_ship_array['trip_from'] = $trips[$i]->trip_from;
               $trip_ship_array['trip_to'] = $trips[$i]->trip_to;
               $trip_ship_array['price'] = $trips[$i]->price;
              
        //compile loop array as object 1 (which pickup_array)
        array_push($trip_array, $trip_ship_array);

        }


       return $trip_array;
        
    }

    public function fetchShip($sId)  // 14
    {
        $trip_select = $sId;  //trip_id :14

                                        //kk    //kch

        $ship_trip = Package::select('trip_from','trip_to','price')
                                    ->where('id', $trip_select)
                                    ->first(); 

        $package_price = $ship_trip->price;                          


         $ship_list = Shipment::select('id','name','port_from','port_to','number', 'date' )
                                    ->where('date', '>', Carbon::today()->addDays(3)->format('Y-m-d'))->orderBy('date','ASC')
                                    ->where('port_from',  $ship_trip->trip_from )
                                    ->where('port_to',  $ship_trip->trip_to )
                                    ->get();
        // return $ship_list;

       $ship_array = array();
       $ship_date_array = array();
       // $ship_include_price = array();


       $ship_date_array['price'] = $package_price;

       array_push($ship_array, $ship_date_array);


       for($i = 0; $i < count($ship_list); $i++){


              $ship_date_array['ship_id'] = $ship_list[$i]->id;
              $ship_date_array['ship_date'] = date('d F, Y', strtotime($ship_list[$i]->date));
              $ship_date_array['ship_name'] = $ship_list[$i]->name;
              $ship_date_array['ship_from'] = $ship_list[$i]->port_from;
              $ship_date_array['ship_to'] = $ship_list[$i]->port_to;
              $ship_date_array['ship_number'] = $ship_list[$i]->number;

              
        // compile loop array as object 1 (which pickup_array)
       array_push($ship_array, $ship_date_array);

       }
        return $ship_array;
        
    }

    //function for dependency dropdown in booking
    public function fetchPickup($pId)
    {

        list($ship_id, $pickup_carrier, $delivery_carrier) = explode(",", $pId);

        $port_from = $ship_id;

        $pickup_location = Shipment::select('port_from','port_to')
                                    ->where('id', $port_from)
                                    ->first();


        // bila fetch collection dari location
        $from_loc = Location::select('id','name','state', 'price')
                    ->where('port',$pickup_location->port_from)
                    ->where('carry_by', $pickup_carrier)
                    ->where('status', 1)
                    ->groupBy('id','name', 'state')
                    ->orderBy('state', 'ASC')
                    ->get();


        // bila fetch collection dari location
        $to_loc = Location::select('id','name','state', 'price')
                    ->where('port',$pickup_location->port_to)
                    ->where('carry_by', $delivery_carrier)
                    ->where('status', 1)
                    ->groupBy('id','name','state')
                    ->orderBy('state', 'ASC')
                    ->get();

        //  //use ->get() to retrive collection of data
        //  //use ->first() to retrive 1 single data          
        

        //create multiple empty array
        $loc_array = array();
        $pickup_loc_array = array();
        $pickup_array = array();
        $delivery_array = array();
        $delivery_loc_array = array();


         //loop data by array (for pickup data)
        for($i = 0; $i < count($from_loc); $i++){

                $pickup_loc_array['pickup_id'] = $from_loc[$i]->id;
                $pickup_loc_array['pickup'] = $from_loc[$i]->name;
                $pickup_loc_array['pickup_state'] = $from_loc[$i]->state;
                $pickup_loc_array['pickup_price'] = $from_loc[$i]->price;

            //compile loop array as object 1 (which pickup_array)
                array_push($pickup_array, $pickup_loc_array);

        }

        //loop data by array (for delivery data)
         for($j = 0; $j < count($to_loc); $j++){

                $delivery_loc_array['delivery_id'] = $to_loc[$j]->id;
                $delivery_loc_array['delivery'] = $to_loc[$j]->name;
                $delivery_loc_array['delivery_state'] = $to_loc[$j]->state;
                $delivery_loc_array['delivery_price'] = $to_loc[$j]->price;

            //compile loop array as object 1 (which pickup_array)
                array_push($delivery_array, $delivery_loc_array);
        }

        //declare multiple array all in 1 array
        $loc_array['pickup'] = $pickup_array;
        $loc_array['delivery'] = $delivery_array;


        // return all in 1 array to js
        return $loc_array;
    
    }


    //retrieve pickup price for each location via id
    public function pickupPrice($pickup_id){

        $pickup_price = Location::select('price')
                                ->where('id', $pickup_id)
                                ->first();

        return $pickup_price;

    }


    //retrieve delivery price for each location via id
    public function deliveryPrice($delivery_id){

        $delivery_price = Location::select('price')
                                ->where('id', $delivery_id)
                                ->first();

        return $delivery_price;

    }


    //retrieve insurance price for each location via market value
    public function insurancePrice($insurance_id){

        //dd($insurance_id);

        $insuran_price = Insurance::select('insurance_price')
                                ->where('id', $insurance_id)
                                ->first();

        return $insuran_price;
    }

    public function fetchCust($cId)
    {
        $customer_data = Customer::select('id','name','phone','email','ic')
                                ->where('id', $cId)
                                ->first();
                            
       return $customer_data;
        
    }

    public function fetchModel($mvId)
    {
        
    //    $make_model = $mvId;
       $model_data = ModelVehicle::select('id','make','model','year','category')
                    ->where('make', $mvId)
                    ->get();

        $model_array = array();
        $model_cat_array = array();

        for($i = 0; $i < count($model_data); $i++){

               $model_cat_array['id'] = strtoupper($model_data[$i]->id);
               $model_cat_array['make'] = strtoupper($model_data[$i]->make);
               $model_cat_array['model'] = strtoupper($model_data[$i]->model);
               $model_cat_array['year'] = $model_data[$i]->year;
               $model_cat_array['category'] = strtoupper($model_data[$i]->category);
              
        //compile loop array as object 1 (which pickup_array)
        array_push($model_array, $model_cat_array);

        }

        return $model_array;
        
    }

    // public function fetchTrips($tId)
    // {
    //     $pack_car = $tId;

    //     $trips = Package::select('id','trip_from','trip_to','price')
    //                                 ->where('car_category', $pack_car)
    //                                 ->get();

    //     //return $trips;

    //     $trip_array = array();
    //     $trip_ship_array = array();

    //     for($i = 0; $i < count($trips); $i++){

    //            $trip_ship_array['trip_id'] = $trips[$i]->id;
    //            $trip_ship_array['trip_from'] = $trips[$i]->trip_from;
    //            $trip_ship_array['trip_to'] = $trips[$i]->trip_to;
    //            $trip_ship_array['price'] = $trips[$i]->price;
              
    //     //compile loop array as object 1 (which pickup_array)
    //     array_push($trip_array, $trip_ship_array);

    //     }


    //    return $trip_array;
        
    // }
}

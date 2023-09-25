<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Booking;
use App\Customer;
use App\Location;
use App\Shipment;
use App\Vehicle;
use App\Payment;
use App\Package;
use App\Insurance;
use App\ModelVehicle;



class PublicBookingController extends Controller
{
    function index(){

        $shipments = Shipment::where('date', '>', Carbon::today()->addDays(3)->format('Y-m-d'))
                            ->orderBy('date','ASC')
                            ->get();

        $packages = Package::select('car_category')
                            ->groupBy('car_category')
                            ->get();

        $locations = Location::select('carry_by')
                            ->whereNull('deleted_at')
                            ->groupBy('carry_by')
                            ->get();
        
        $model_vehicles = ModelVehicle::select('make')
        ->groupBy('make')
        ->get();

        $insurances = Insurance::all();



        return view('public.booking', compact('shipments', 'locations', 'packages','insurances','model_vehicles'));


    }

    function post(Request $request){

        // dd($request)->validate();

         $this->validate($request, [
            'name'=>'required',
            'contact'=>'required|min:10|max:12',
            'email'=>'required|email',
            'id_no'=>'required|max:12',
            'shipment_trip' => 'required|exists:packages,id',
            'shipment_date' => 'required|exists:shipments,id',
            // 'options'=>'required',
            'pickup_location' => 'required_if:options,3|required_if:options,4',
            'delivery_location' => 'required_if:options,2|required_if:options,4',
            'vehicle_market_value' => 'nullable|exists:insurances,id',
            'total_price'=>'required',
            'body_type'=>'required',
            'vehicle_registration_no'=>'required',
            'model'=>'required',
            'attachment_geran'=>'nullable|mimes:pdf,png,jpg,bmp|max:5000',
            'attachment_bank'=>'nullable| mimes:pdf,png,jpg,bmp|max:5000',
            'attachment_ic' =>'nullable| mimes:pdf,png,jpg,bmp|max:5000',

        ]);

        $customer = new Customer;

            $customer->name = strtoupper($request['name']);
            $customer->phone = $request['contact'];
            $customer->email = $request['email'];
            $customer->ic = $request['id_no'];

            
        
            if($request->has('attachment_ic')){
                
                $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/customer_ic";
                if(!file_exists($directory)){
                    mkdir($directory, 0755, true);    
                }

                $file_name = "ic_".$request['id_no']."_".time().".".$request->attachment_ic->getClientOriginalExtension();
                $file = $request->attachment_ic;
                $file->move($directory, $file_name);
                $customer->attachment_ic = "uploads/customer_ic/" .$file_name;

            }else{
                $customer->attachment_ic = "";
            }
           
            $customer->save();

        $booking = new Booking;

            $booking->customer_id = $customer->id;
            $booking->package_id = $request['shipment_trip'];
            $booking->shipment_id = $request['shipment_date'];
           
                if($request['pickup_location'] == '') {
                    $booking->location_id_pickup = "1";
                }else {
                    $booking->location_id_pickup = $request['pickup_location'];
                }

                if($request['delivery_location'] == '') {
                    $booking->location_id_delivery = "1";
                }else {
                    $booking->location_id_delivery = $request['delivery_location'];
                }

            if($request['vehicle_market_value'] == '') {
                    $booking->insurance_id = "0";
                }else {
                    $booking->insurance_id = $request['vehicle_market_value'];
                }

            $booking->amount = preg_replace('/[^0-9-.]+/', '', $request['total_price']);

            $current_running = Booking::withTrashed()->count()+1; //kene gune bila dah add sofdelete
            //$current_running = Booking::count()+1;
            $booking->booking_no = "B". str_pad($current_running, 5, '0', STR_PAD_LEFT);
            $booking->booking_date = date('Y-m-d');
            //$booking->booking_price = 0;
            $booking->booking_status = "NEW";

            $booking->save();


        $vehicle = new Vehicle;

            $vehicle->customer_id = $customer->id;
            $vehicle->booking_id = $booking->id;
            $vehicle->plate_no = strtoupper($request['vehicle_registration_no']);
            $vehicle->model = strtoupper($request['model']);
            $vehicle->type = $request['body_type'];

        if($request->has('attachment_geran')){

            $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/geran";
            if(!file_exists($directory)){
                mkdir($directory, 0755, true);    
            }
            $file_name = "geran_".$customer->id."_".time().".".$request->attachment_geran->getClientOriginalExtension();
            $file = $request->attachment_geran;
            $file->move($directory, $file_name);
            $vehicle->file_geran = "uploads/geran/" .$file_name;

        }else{
            $vehicle->file_geran= "";
        }

        if($request->has('attachment_bank')){

            $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/bank";
            if(!file_exists($directory)){
                mkdir($directory, 0755, true);    
            }
            $file_name = "bank_".$customer->id."_".time().".".$request->attachment_bank->getClientOriginalExtension();
            $file = $request->attachment_bank;
            $file->move($directory, $file_name);
            //$vehicle->file_loan = $directory. "/" .$file_name;
            $vehicle->file_loan = "uploads/bank/" .$file_name;

        }else{
                $vehicle->file_loan= "";
            } 

            $vehicle->save();

            return redirect()->route('payment.create-payment', $customer);


    }

    public function success(){

        return view('public.booking_succes');
    }

    
    
}

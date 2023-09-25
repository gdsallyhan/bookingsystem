<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PaymentController;
use App\Notifications\BooksNotification;
use App\Exports\BookingExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Barryvdh\DomPDF\Facade\Options;
use Carbon\Carbon;
use App\Booking;
use App\Shipment;
use App\Vehicle;
use App\Location;
use App\Customer;
use App\Package;
use App\User;
use App\Insurance;
use App\Payment;
use App\ModelVehicle;
use File;
use Response;
// use PDF;


class BookingController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth'); //sapa nak excesss controlrer  kene login in dulu  kene letak dlm controller
    }

  
    public function index(Request $request)
    {
        if($request->has('search')){

            $search = $request->search; 

            $bookings = Booking::withTrashed()
                                ->join('customers', 'customers.id', '=', 'bookings.customer_id')
                                ->join('shipments', 'shipments.id', '=', 'bookings.shipment_id')
                                ->join('locations', 'locations.id', '=', 'bookings.location_id_delivery')
                                ->join('vehicles', 'vehicleS.booking_id', '=', 'bookings.id')
                                ->where('customers.name','like','%'.$search. '%') 
                                ->orwhere('booking_no','like','%'.$search. '%') 
                                ->orwhere('shipments.name','like','%'.$search. '%')
                                ->orwhere('shipments.number','like','%'.$search. '%')
                                ->orWhere('shipments.port_from','like','%'.$search. '%')
                                ->orWhere('shipments.port_to','like','%'.$search. '%')
                                // ->orwhere('locations.name','like','%'.$search. '%')
                                ->orWhere('booking_status','like','%'.$search. '%')
                                ->orderBy('booking_no', 'DESC')
                                ->paginate(10);
            $bookings->appends($request->all());

                                
        }else{

             $bookings = Booking::join('vehicles', 'vehicles.booking_id', '=', 'bookings.id')
                                ->orderBy('booking_no', 'DESC')
                                ->paginate(10);                        
        }

              // $bookings = Booking::withTrashed()
              //                   ->paginate(15);
                
        return view('booking_index',compact('bookings'));
    }


    public function create()
    {
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
        $customers = Customer::all();

        // To get data & display location 
        //$locations = Location::where('status', 1)
                                //where('port_to', )->get();

        return view('booking_form_create', compact('shipments','packages','insurances','locations','customers','model_vehicles'));
    }


     public function store(Request $request)
    {
         $this->validate($request, [
            'cust_id'=>'nullable',
            'name'=>'required',
            'contact'=>'required|min:10|max:12',
            'email'=>'required|email',
            'ic_no'=>'required|max:12',
            'shipment_trip' => 'required|exists:packages,id',
            'shipment_date' => 'required|exists:shipments,id',
            'pickup_location' => 'required_if:options,3|required_if:options,4',
            'delivery_location' => 'required_if:options,2|required_if:options,4',
            'vehicle_market_value' => 'nullable|exists:insurances,id',
            'total_price'=>'required',
            'model_id'=>'nullable',
            // 'make'=>'nullable',
            'model'=>'nullable',
            'year'=>'nullable',
            'body_type'=>'nullable',
            'vehicle_registration_no'=>'required',
            'attachment_geran'=>'nullable|mimes:pdf,png,jpg,bmp|max:5000',
            'attachment_bank'=>'nullable| mimes:pdf,png,jpg,bmp|max:5000',
            'attachment_ic' =>'nullable| mimes:pdf,png,jpg,bmp|max:5000',
            'keyin'=>'required',
            'engine_no'=>'required',
            'chasis_no'=>'required',
            'color'=>'required',
            'notes'=>'nullable',
            'personal_effect'=>'nullable',
        ]);


        if($request->cust_id == ""){

            $customer = new Customer;

            $customer->name = strtoupper($request['name']);
            $customer->phone = $request['contact'];
            $customer->email = $request['email'];
            $customer->ic = $request['ic_no'];

            if($request->has('attachment_ic')){

                $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/customer_ic";
                if(!file_exists($directory)){
                    mkdir($directory, 0755, true);    
                }
    
                $file_name = "ic_".$request['ic_no']."_".time().".".$request->attachment_ic->getClientOriginalExtension();
                $file = $request->attachment_ic;
                $file->move($directory, $file_name);
                $customer->attachment_ic = "uploads/customer_ic/" .$file_name;

            }else{
                $customer->attachment_ic = "";
            }

            $customer->save();

        }else{
            $customer = Customer::select('id')
                                ->where('id', $request->cust_id)
                                ->first();
        }
        

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
            $booking->notes = strtoupper($request['notes']);
            $current_running = Booking::withTrashed()->count()+1; //kene gune bila dah add sofdelete
            //$current_running = Booking::count()+1;
            $booking->booking_no = "B". str_pad($current_running, 5, '0', STR_PAD_LEFT);
            $booking->booking_date = date('Y-m-d');
            $booking->booking_status = "PENDING";
            $booking->user_id = $request['keyin'];
        
        $booking->save();

        $vehicle = new Vehicle;

        if($request->model_id > 0){

            $vehicle->model_id = $request['model_id'];

        }else{

            $model_vehicles = new ModelVehicle;

            list($make, $model) = explode(' ',$request['model'],2);

            $model_vehicles->make = strtoupper($make);
            $model_vehicles->model = strtoupper($model);
            $model_vehicles->year = strtoupper($request['year']);
            $model_vehicles->category = strtoupper($request['body_type']);
            $model_vehicles->save();

            $vehicle->model_id = $model_vehicles->id;

        }

            // $vehicle->model = strtoupper($request['model']);
            // $vehicle->year = $request['year'];
            // $vehicle->type = $request['body_type'];

            $vehicle->customer_id = $customer->id;
            $vehicle->booking_id = $booking->id;
            $vehicle->plate_no = strtoupper($request['vehicle_registration_no']);
            $vehicle->engine = strtoupper($request['engine_no']);
            $vehicle->chasis = strtoupper($request['chasis_no']);
            $vehicle->color = strtoupper($request['color']);
            $vehicle->personal_effect = strtoupper($request['personal_effect']);

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

            /* Function notification count booking */
            // $sendNotify = Booking::first();
            $user = User::all();
            $sendNotify = Booking::select('name','booking_no','booking_date','bookings.created_at','bookings.id')
                        ->join('customers', 'customers.id','=','bookings.customer_id')
                        ->latest()
                        ->first();

            Notification::send($user, new BooksNotification($sendNotify));
        
            if ($request->has('save')) {
                   
                // get function create payment bill from payment controller
                $paymentController = (new PaymentController)->createPaymentBill($request, $customer);
               
                //remove html header from function createPaymentBill
                $parsed_url = parse_url($paymentController);
                $query_string = isset($parsed_url['path']) ? $parsed_url['path'] : '';
                parse_str($query_string, $query_params);
                $bill_code = isset($query_params['bill_code']) ? $query_params['bill_code'] : null;

                //save payment link in booking table
                // $booking->payment_link = $bill_code;
                // $booking->save();
            
                return redirect()->route('booking.index');
                // dd($bill_code);
            }

        return redirect()->route('payment.create-payment',$customer);

    }

   //function edit booking
    public function edit(Booking $booking)
    {
        $shpId = Booking::select('shipment_id')
                                ->where('id', $booking->id)
                                ->first();

        $getPort = Shipment::select('port_from','port_to')
                                ->where('id', $shpId->shipment_id)
                                ->first();

        $shipments = Shipment::where('date', '>', Carbon::today()->addDays(3)->format('Y-m-d'))
                                ->orderBy('date','ASC')
                                ->where('port_from', $getPort->port_from)
                                ->where('port_to', $getPort->port_to)
                                ->get();

        // $packages = Package::select('car_category')
        //                     ->groupBy('car_category')
        //                     ->get();

        // $locations = Location::where('status', 1)->get();

        $vehicles = Vehicle::select('model_id')
                            ->where('booking_id', $booking->id)
                            ->first();

        // $insurances = Insurance::all();
        $model_vehicles = ModelVehicle::all()
                            ->where('id',$vehicles->model_id)
                            ->first();
                                

        return view('booking_form', compact('booking','shipments','vehicles','model_vehicles'));
    }

    
    public function update(Request $request, Booking $booking)
    {
        $this->validate($request, [
            'shipment_date' => 'nullable|exists:shipments,id',
            // 'location_id_pickup' => 'nullable|exists:locations,id',
            // 'location_id_delivery' => 'nullable|exists:locations,id',
            // 'type'=>'nullable',
            // 'plate_no'=>'nullable',
            // 'model'=>'nullable',
            // 'attachment_geran'=>'nullable|mimes:pdf,png,jpg,bmp|max:5000',
            //'attachment_bank'=>'required| mimes:pdf,png,jpg,bmp|max:5000',
            //'attachment_ic' =>'required| mimes:pdf,png,jpg,bmp|max:5000',

        ]);

         $booking->shipment_id = $request['shipment_date'];
         // $booking->location_id_pickup = $request['location_id_pickup'];
         // $booking->location_id_delivery = $request['location_id_delivery'];
         $booking->save();
            
        //  $vehicle = Vehicle::where('booking_id', $booking->id)->first();
        //  $vehicle = Vehicle::where('customer_id',$booking->customer_id)->first();
        //  $vehicle->booking_id = $booking->id;
        //  $vehicle->customer_id = $booking->customer_id;
        //  $vehicle->type = $request['type'];
        //  $vehicle->plate_no = $request['plate_no'];
        //  $vehicle->model = $request['model']; 

        // if($request->hasFile('attachment_geran'))
        // {
        //     $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/geran";
        //     if(!file_exists($directory)){
        //        mkdir($directory, 0755, true);    
        //      }

        //  $file_name = "geran_".$vehicle->customer_id."_".time().".".$request['attachment_geran']->getClientOriginalExtension();
        //  $file = $request['attachment_geran'];
        //  $file->move($directory, $file_name);
        //  $vehicle->file_geran = "uploads/geran/" .$file_name;
        // }

        //  $vehicle->save();

        return redirect()->route('booking.index');
        
    }

    public function destroy(Request $request, Booking $booking)
        {
            $booking->booking_status = $request['booking_status'];
            $booking->save();
            $booking->delete();

            $vehicle = Vehicle::where('booking_id', $booking->id)->first();
            $vehicle->booking_id = $booking->id;
            $vehicle->delete();
            
            //$booking->delete();

             return redirect()->route('booking.index');
        }

    /*show view quotation*/    
    public function show($id)
        {
            $booking = Booking::findOrFail($id);
            
            $vehicle = Vehicle::select('model_id')
                            ->where('booking_id', $booking->id)
                            ->first();

            $model_vehicle =ModelVehicle::where('id', $vehicle->model_id)
                            ->first();
                            
            return view('booking_quoteView', compact('booking','model_vehicle'));
            // dd($model_vehicle);
        }

        public function showInvoice($id)
        {
            $booking = Booking::findOrFail($id);

            $vehicle = Vehicle::where('id', $booking->vehicle_id)->first();
        
            return view('booking_invoiceView', compact('booking', 'vehicle'));
            // dd($booking);
            
        }

        public function showReceipt($id)
        {
            $booking = Booking::findOrFail($id);

            $vehicle = Vehicle::where('id', $booking->vehicle_id)->first();
        
            return view('booking_receiptView', compact('booking', 'vehicle'));
            // dd($booking);
            
        }

        public function showConfirm($id)
        {
            $booking = Booking::findOrFail($id);
            
            $vehicle = Vehicle::select('model_id')
                            ->where('booking_id', $booking->id)
                            ->first();

            $model_vehicle =ModelVehicle::where('id', $vehicle->model_id)
                            ->first();
        
            return view('booking_confirmView', compact('booking', 'model_vehicle'));
            // dd($booking);
            
        }

    public function linkFileID($booking)
        {
            $getFileID = Booking::select('customer_id')
                        ->where('id', $booking)
                        ->first();
            $custID = $getFileID->customer_id;

            $getCustAttch = Customer::select('attachment_ic')
                            ->where('id', $custID)
                            ->first();
            $ID = $getCustAttch->attachment_ic;

            $path =  $_SERVER['DOCUMENT_ROOT']."/".$ID;
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::stream(function() use($file) 
            {
                echo $file;
            }, 200, ["Content-Type"=> $type]);

            return $response;
    
        }    

     public function linkFileGrant($booking)
        {
            $getFileGrant = Vehicle::select('file_geran')
                        ->where('booking_id', $booking)
                        ->firstOrFail();
            $vehicleGrant = $getFileGrant->file_geran;

            $path =  $_SERVER['DOCUMENT_ROOT']."/".$vehicleGrant;
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::stream(function() use($file) 
            {
                echo $file;
            }, 200, ["Content-Type"=> $type]);

            return $response;
        }

        public function linkFileLoan($booking)
        {
            $getFileLoan = Vehicle::select('file_loan')
                        ->where('booking_id', $booking)
                        ->firstOrFail();
            $vehicleLoan = $getFileLoan->file_loan;

            $path =  $_SERVER['DOCUMENT_ROOT']."/".$vehicleLoan;
            $file = File::get($path);
            $type = File::mimeType($path);
            $response = Response::stream(function() use($file) 
            {
                echo $file;
            }, 200, ["Content-Type"=> $type]);

            return $response;

        }

        // public function logoCop() 
        // {
        //     $path_logo = base_path('public/icon/logo.jpg');
        //     $type = pathinfo($path_logo, PATHINFO_EXTENSION);
        //     $file = file_get_contents($path_logo);
        //     $logo ='data:image/'.$type.';base64,'.base64_encode($file);

        //     $path_cop = base_path('public/icon/cop-ventura.png');
        //     $type = pathinfo($path_cop, PATHINFO_EXTENSION);
        //     $file = file_get_contents($path_cop);
        //     $cop ='data:image/'.$type.';base64,'.base64_encode($file);

        //     $logoCop = [$logo,$cop];

        //     return $logoCop;
        // }
        
        
        public function quotePDF($booking) 
        {
                $data = Booking::where('id', $booking)->first();
                $vehicle = Vehicle::select('model_id')->where('booking_id',$data->id)->first();
                $model_vehicle = ModelVehicle::where('id', $vehicle->model_id)->first();

                $path_logo = base_path('public/icon/logo.jpg');
                $type = pathinfo($path_logo, PATHINFO_EXTENSION);
                $file = file_get_contents($path_logo);
                $logo ='data:image/'.$type.';base64,'.base64_encode($file);

                $path_cop = base_path('public/icon/cop-ventura.png');
                $type = pathinfo($path_cop, PATHINFO_EXTENSION);
                $file = file_get_contents($path_cop);
                $cop ='data:image/'.$type.';base64,'.base64_encode($file);

                // list($logo,$cop) = explode(' ',$this->logoCop($logoCop),2);

                $pdf = PDF::loadView('pdf/booking_quoteView_export', compact('data','model_vehicle', 'logo','cop' ))->setOptions(['isHtml5Parser' =>true, 'isRemoteEnabled' => true]);
                $pdf->render();

                return $pdf->stream('Book No. '.$data->booking_no.' ('.$data->customer()->name.').pdf');
                // dd($model_vehicle);

        }

        public function invoicePDF($booking) 
        {
                $data = Booking::where('id', $booking)->first();
                $vehicle = Vehicle::select('model_id')->where('booking_id',$data->id)->first();
                $model_vehicle = ModelVehicle::where('id', $vehicle->model_id)->first();

                $path_logo = base_path('public/icon/logo.jpg');
                $type = pathinfo($path_logo, PATHINFO_EXTENSION);
                $file = file_get_contents($path_logo);
                $logo ='data:image/'.$type.';base64,'.base64_encode($file);

                $path_cop = base_path('public/icon/cop-ventura.png');
                $type = pathinfo($path_cop, PATHINFO_EXTENSION);
                $file = file_get_contents($path_cop);
                $cop ='data:image/'.$type.';base64,'.base64_encode($file);

                $pdf = PDF::loadView('pdf/booking_invoiceView_export', compact('data','model_vehicle', 'logo','cop' ))->setOptions(['isHtml5Parser' =>true, 'isRemoteEnabled' => true]);
                $pdf->render();

                return $pdf->stream('Book No. '.$data->booking_no.' ('.$data->customer()->name.').pdf');
                // dd($model_vehicle);

        }

        public function receiptPDF($booking) 
        {
                $data = Booking::where('id', $booking)->first();
                $vehicle = Vehicle::select('model_id')->where('booking_id',$data->id)->first();
                $model_vehicle = ModelVehicle::where('id', $vehicle->model_id)->first();

                $path_logo = base_path('public/icon/logo.jpg');
                $type = pathinfo($path_logo, PATHINFO_EXTENSION);
                $file = file_get_contents($path_logo);
                $logo ='data:image/'.$type.';base64,'.base64_encode($file);

                $path_cop = base_path('public/icon/cop-ventura.png');
                $type = pathinfo($path_cop, PATHINFO_EXTENSION);
                $file = file_get_contents($path_cop);
                $cop ='data:image/'.$type.';base64,'.base64_encode($file);

                $pdf = PDF::loadView('pdf/booking_receiptView_export', compact('data','model_vehicle', 'logo','cop' ))->setOptions(['isHtml5Parser' =>true, 'isRemoteEnabled' => true]);
                $pdf->render();

                return $pdf->stream('Book No. '.$data->booking_no.' ('.$data->customer()->name.').pdf');
                // dd($model_vehicle);

        }

        public function confirmPDF($booking) 
        {
                $data = Booking::where('id', $booking)->first();
                $vehicle = Vehicle::select('model_id')->where('booking_id',$data->id)->first();
                $model_vehicle = ModelVehicle::where('id', $vehicle->model_id)->first();

                $path_logo = base_path('public/icon/logo.jpg');
                $type = pathinfo($path_logo, PATHINFO_EXTENSION);
                $file = file_get_contents($path_logo);
                $logo ='data:image/'.$type.';base64,'.base64_encode($file);

                $path_cop = base_path('public/icon/cop-ventura.png');
                $type = pathinfo($path_cop, PATHINFO_EXTENSION);
                $file = file_get_contents($path_cop);
                $cop ='data:image/'.$type.';base64,'.base64_encode($file);

                $pdf = PDF::loadView('pdf/booking_confirmView_export', compact('data','model_vehicle', 'logo','cop' ))->setOptions(['isHtml5Parser' =>true, 'isRemoteEnabled' => true]);
                $pdf->render();

                return $pdf->stream('Book No. '.$data->booking_no.' ('.$data->customer()->name.').pdf');
                // dd($model_vehicle);

        }

        public function export()
        {
            return Excel::download(new BookingExport, 'bookings.xlsx');
        }

    // public function restore(Booking $booking)
    //     {

    //         // //dd($booking);
    //         //  Booking::withTrashed()->find($booking)->restore();
            
    //         //  return redirect()->route('booking.index');
    //     }

   
}

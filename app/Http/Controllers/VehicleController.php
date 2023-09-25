<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehicle;
use App\Customer;
use App\ModelVehicle;
use File;
use Response;


class VehicleController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth'); //sapa nak excesss controlrer  kene login in dulu  kene letak dlm controller
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        //dd($request);
        if($request->has('search')){

            $search = $request->search; 

            $vehicles = Vehicle::join('customers', 'customers.id', '=', 'vehicles.customer_id')
                                ->join('bookings', 'bookings.id', '=', 'vehicles.booking_id')
                                ->where('name','like','%'.$search. '%') 
                                ->orwhere('booking_no','like','%'.$search. '%')                  
                                ->orWhere('type','like','%'.$search. '%')
                                ->orWhere('plate_no','like','%'.$search. '%')
                                ->orWhere('model','like','%'.$search. '%')
                                ->orderBy('booking_no', 'ASC')
                                ->paginate(15);

            $vehicles->appends($request->all());
                                
        }else{

             $vehicles =Vehicle:: join('customers', 'customers.id', '=', 'vehicles.customer_id')
                                ->join('bookings', 'bookings.id', '=', 'vehicles.booking_id')
                                ->orderBy('booking_no', 'DESC')
                                ->paginate(15);
        }


        return view('vehicle_index',compact('vehicles'));
    }


    /**
     * Show the form for creating a new resource.
     */
     public function create()
     {
         // $vehicle = new Location;
         // return view('vehicle_form', compact('vehicle'));
     }


    /**
     * Store a newly created resource in storage.
     */
     public function store(Request $request) //validation & save
     {
         // $this->validate($request, [
         //     'name'=>'required',
         //     'state'=>'required',
         //     'status'=>'required|in:0,1',

         // ]);

         // $vehicle = new Vehicle;
         // $vehicle->name = $request['name'];
         // $vehicle->state = $request['state'];
         // $vehicle->status = $request['status'];
         // $vehicle->save()
         // return redirect()->route('vehicle.index');

     }


    /**
     * Display the specified resource.
     */
    public function show(Vehicle $vehicle)
    {

        // dd($vehicle);
        // return $vehicles;
        return view('vehicle_view', compact('vehicle'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vehicle $vehicle)
    {
        $model_vehicles  = ModelVehicle::select('make')
                            ->groupBy('make')
                            ->get();
        
        // $model_vehicles = ModelVehicle::all()
        //         ->where('id',$vehicle->model_id)
        //         ->first();

        // dd($model_vehicles);
                
         return view('vehicle_form', compact('vehicle','model_vehicles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->validate($request, [
            'type'=>'required',
            'model'=>'required',
            'plate_no'=>'required|exists:vehicles,plate_no',
            'engine'=>'required',
            'chasis'=>'required',
            'color'=>'required',
            'year'=>'required',
            'personal_effect'=>'nullable',

        ]);

        $vehicle->type = $request['type'];
        $vehicle->model = $request['model'];
        $vehicle->plate_no = $request['plate_no'];
        $vehicle->engine = $request['engine'];
        $vehicle->chasis = $request['chasis'];
        $vehicle->color = $request['color'];
        $vehicle->year = $request['year'];

        if($request['personal_effect'] == ""){
            $vehicle->personal_effect = "no personal effect";
        }
        else{
            $vehicle->personal_effect = $request['personal_effect'];
        }

        $vehicle->save();

        return redirect()->route('vehicle.index');
        
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

         return redirect()->route('vehicle.index');
    }


    public function vLinkFileGrant(Vehicle $vehicle)
        {

                dd($vehicle->file_geran);
                // $path =  $_SERVER['DOCUMENT_ROOT']."/".$vehicle->file_geran;
                // $file = File::get($path);
                // $type = File::mimeType($path);
                // $response = Response::stream(function() use($file) {
                //   echo $file;
                // }, 200, ["Content-Type"=> $type]);

                //  return $response;

        }

        public function vLinkFileLoan(Vehicle $vehicle)
        {

                $path =  $_SERVER['DOCUMENT_ROOT']."/".$vehicle->file_loan;
                $file = File::get($path);
                $type = File::mimeType($path);
                $response = Response::stream(function() use($file) {
                  echo $file;
                }, 200, ["Content-Type"=> $type]);

                 return $response;

        }


}

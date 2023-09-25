<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shipment;

class ShipmentController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
     public function __construct()
    {
        $this->middleware('auth'); //sapa nak excesss controlrer  kene login in dulu  kene letak dlm controller
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('search')){


            $shipments = Shipment::where('name','like','%'.$request->search. '%')
                                ->orWhere('number','like','%'.$request->search. '%')
                                ->orWhere('port_to','like','%'.$request->search. '%')
                                ->orWhere('port_from','like','%'.$request->search. '%')
                                ->orderBy('date', 'ASC')
                                ->paginate(10);
            $shipments->appends($request->all());


        return view('shipment_index',compact('shipments'));

        }else{

             $shipments =Shipment::orderBy('date', 'DESC')
                            ->paginate(10);

      

        }
       
                            
         return view('shipment_index',compact('shipments'));

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $shipment = new Shipment;
        return view('shipment_form', compact('shipment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //nakbuat validation
    {
        $this->validate($request, [
            'date'=>'required',
            'name'=>'required',
            'number'=>'required',
            'port_from'=>'required',
            'port_to'=>'required',
           // 'status'=>'required|in:0,1',

        ]);

        $shipment = new Shipment;

        $shipment->date = $request['date'];
        $shipment->name = $request['name'];
        $shipment->number = $request['number'];
        $shipment->port_from = $request['port_from'];
        $shipment->port_to = $request['port_to'];
       // $shipment->status = $request['status'];
        $shipment->save();

        return redirect()->route('shipment.index');
        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        //dd($shipment);
         return view('shipment_form', compact('shipment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        $this->validate($request, [
            'date'=>'required',
            'name'=>'required',
            'number'=>'required',
            'port_from'=>'required',
            'port_to'=>'required',

        ]);



        $shipment->date = $request['date'];
        $shipment->name = $request['name'];
        $shipment->number = $request['number'];
        $shipment->port_from = $request['port_from'];
        $shipment->port_to = $request['port_to'];
       // $shipment->status = $request['status'];
        $shipment->save();


        return redirect()->route('shipment.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
         return redirect()->route('shipment.index');
    }


    
   
    

}

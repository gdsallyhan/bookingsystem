<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;

use App\Location;

class LocationController extends Controller
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


            $locations = Location::where('name','like','%'.$request->search. '%')
                                ->orWhere('state','like','%'.$request->search. '%')
                                ->orWhere('port','like','%'.$request->search. '%')
                                ->orWhere('price','like','%'.$request->search. '%')
                                ->orWhere('status','like','%'.$request->search. '%')
                                ->orWhere('carry_by','like','%'.$request->search. '%')
                                
                                ->orderBy('name', 'ASC')
                                ->paginate(15);

            $locations->appends($request->all());

        return view('location_index',compact('locations'));

        }else{

             $locations =Location::orderBy('name', 'ASC')
                            ->paginate(15);
                            
        }                    
        return view('location_index',compact('locations'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = new Location;
        return view('location_form', compact('location'));
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
            'name'=>'required',
            'state'=>'required',
            'status'=>'required|in:0,1',
            'port' =>'required',
            'price' =>'required',
            'carry_by' =>'required',

        ]);

        $location = new Location;

        $location->name = $request['name'];
        $location->state = $request['state'];
        $location->status = $request['status'];
        $location->port = $request['port'];
        $location->price = $request['price'];
        $location->carry_by = $request['carry_by'];
        $location->save();

        return redirect()->route('location.index');
        

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
    public function edit(Location $location)
    {
        //dd($staff);
         return view('location_form', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $this->validate($request, [
            'name'=>'required',
            'state'=>'required',
            'status'=>'required|in:0,1',
            'port'=>'required',
            'price'=>'required',
            'carry_by' =>'required',
        ]);

        $location->name = $request['name'];
        $location->state = $request['state'];
        $location->status = $request['status'];
        $location->port = $request['port'];
        $location->price = $request['price'];
        $location->carry_by = $request['carry_by'];
        $location->save();

        return redirect()->route('location.index');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();
         return redirect()->route('location.index');
    }

}

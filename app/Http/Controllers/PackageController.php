<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Package;

class PackageController extends Controller
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

            $packages = Package::where('car_category','like','%'.$request->search. '%')
                                ->orWhere('trip_from','like','%'.$request->search. '%')
                                ->orWhere('trip_to','like','%'.$request->search. '%')
                                ->orWhere('price','like','%'.$request->search. '%')
                                
                                ->orderBy('car_category', 'ASC')
                                ->paginate(15);

            $packages->appends($request->all());
            
        }else{

             $packages =Package::orderBy('car_category', 'ASC')
                            ->paginate(15);
        }
        

        return view('package_index',compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $package = new Package;
        return view('package_form', compact('package'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [

            'car_category'=>'required',
            'trip_from'=>'required',
            'trip_to'=>'required',
            'price' =>'required',

        ]);

        $package = new Package;

        $package->car_category = $request['car_category'];
        $package->trip_from = $request['trip_from'];
        $package->trip_to = $request['trip_to'];
        $package->price = $request['price'];
        $package->save();

        return redirect()->route('package.index');
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
    public function edit( Package $package)
    {
        //dd($staff);
         return view('package_form', compact('package'));
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Package $package)
    {
        $this->validate($request, [
            'car_category'=>'required',
            'trip_from'=>'required',
            'trip_to'=>'required',
            'price' =>'required',

        ]);

        $package->car_category = $request['car_category'];
        $package->trip_from = $request['trip_from'];
        $package->trip_to = $request['trip_to'];
        $package->price = $request['price'];
        $package->car_category;
        $package->save();


        return redirect()->route('package.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

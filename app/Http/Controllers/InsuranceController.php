<?php

namespace App\Http\Controllers;

use App\Notifications\BooksNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use App\Insurance;
use App\User;

class InsuranceController extends Controller
{

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

        $insurances = Insurance::orderBy('market_value','ASC')
                                ->paginate(10);
;
        if($request->has('search')){

            $insurances = Insurance::where('market_value','like','%'.$request->search. '%')
                                ->orWhere('insurance_price','like','%'.$request->search. '%')
                                ->orderBy('market_value', 'ASC')
                                ->paginate(10);
                $insurances->appends($request->all());

        }else{

             $insurances =Insurance::orderBy('market_value', 'ASC')
                            ->paginate(10);
        }


        return view('insurance_index',compact('insurances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $insurance = new Insurance;
        return view('insurance_form', compact('insurance'));
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
            'market_value'=>'required',
            'insurance_price'=>'required',

        ]);

        // $user = User::all();
        $insurance = new Insurance;
        $insurance->market_value = $request['market_value'];
        $insurance->insurance_price = $request['insurance_price'];
        $insurance->save();

        // Notification::send($user, new BooksNotification($insurance->insurance_price));

        return redirect()->route('insurance.index');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        return view('insurance_form', compact('insurance'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insurance $insurance )
    {
        $this->validate($request, [
            'market_value'=>'required',
            'insurance_price'=>'required',

        ]);

        $insurance->market_value = $request['market_value'];
        $insurance->insurance_price = $request['insurance_price'];
        $insurance->save();

        return redirect()->route('insurance.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Insurance $insurance)
    {
        $insurance->delete();
        return redirect()->route('insurance.index');
    }
}

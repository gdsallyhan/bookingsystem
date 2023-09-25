<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Booking;
use App\Shipment;
use App\Vehicle;
use App\Location;
use App\Customer;
use App\Package;
use App\User;
use App\Insurance;
use File;
use Response;

class ChartController extends Controller
{
    
    public function index()
    {
        // // $Y = Booking::select(DB::raw("count(*) as count"))
        // $chartBook = Booking::withTrashed()->select(DB::raw("date(created_at) as dates"),DB::raw("count(id) as countbook"), DB::raw("count(deleted_at) as countcancel"))
        //                     ->groupBy(DB::raw("date(created_at)"))
        //                     ->get();

        // // $X = Booking::select(DB::raw("date(created_at)"))
        // //                     ->groupBy(DB::raw("date(created_at)"))
        // //                     ->get();


        // $data = "";
        // foreach($chartBook as $val){
        //     $data.= "['".$val->dates."',".$val->countbook.",".$val->countcancel."],";
        // }

        // // dd($data);
        // return view('chart', compact('data'));
       
                            
    }

   
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

  
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}

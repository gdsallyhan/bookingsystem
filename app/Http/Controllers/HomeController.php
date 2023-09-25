<?php

namespace App\Http\Controllers;
use App\Notifications\BooksNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Booking;
use App\Shipment;
use App\Vehicle;
use App\Location;
use App\Customer;
use App\User;
use File;
use Response;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $total_book = Booking::withTrashed()->count();
        $paid_book = Booking::where('booking_status', 'paid')->count();
        $pending_book = Booking::where('booking_status', 'pending')->count();
        $cancel_book = Booking::onlyTrashed()->get()->count();
        
                                    
        $chartBook = Booking::withTrashed()->select(DB::raw("date(created_at) as dates"), DB::raw("count(id) as countbook"), DB::raw("count(deleted_at) as countcancel"))
        // $chartBook = Booking::select(DB::raw("date(created_at) as dates"), DB::raw("count(id) as countbook"))
                            ->groupBy("dates")
                            ->orderBy("dates")
                            ->get();

            $data = "";
            foreach($chartBook as $val){
                $data.= "['".date('dS M Y', strtotime($val->dates))."',".$val->countbook.",".$val->countcancel."],";
            }

            // dd($data);
            // return view('chart', compact('data'));

        return view('home',compact('total_book', 'cancel_book','paid_book','pending_book','data'));
    }


    // public function markasread(Request $request) {
    //     $success = auth()->user()->unreadNotifications->markAsRead();
    //     return redirect()->back();
    // }

    public function markasread($id)
        {
            if($id){
                auth()->user()->unreadNotifications->where('id',$id)->markAsRead();

            }

                $notification = auth()->user()->notifications->where('id',$id)->first();
                $dataId = $notification->data['booking_id'];

            // dd($dataId);
            return redirect()->to(route('booking.show', $dataId));
            
        }

    public function generateChart()
    {
        $chartBook = Booking::withTrashed()->select(DB::raw("date(created_at) as dates"), DB::raw("count(id) as countbook"), DB::raw("count(deleted_at) as countcancel"))
        // $chartBook = Booking::select(DB::raw("date(created_at) as dates"), DB::raw("count(id) as countbook"))
                            ->groupBy("dates")
                            ->orderBy("dates")
                            ->get();

            $data = "";
            foreach($chartBook as $val){
                $data.= "['".date('dS M Y', strtotime($val->dates))."',".$val->countbook.",".$val->countcancel."],";
            }

            
            // dd($data);
           return response()->json($data);
           // return view('chart', compact('data'));



    }

}

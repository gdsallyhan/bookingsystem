<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Customer;
use File;
use Response;




class CustomerController extends Controller
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

        if($request->has('search')){

            $customers = Customer::where('name','like','%'.$request->search. '%')
                                ->orWhere('phone','like','%'.$request->search. '%')
                                ->orWhere('email','like','%'.$request->search. '%')
                                ->orWhere('ic','like','%'.$request->search. '%')
                                
                                ->orderBy('name', 'ASC')
                                ->paginate(10);
            $customers->appends($request->all());

        }else{

             $customers =Customer::orderBy('name', 'ASC')
                            ->paginate(10);
        }


        return view('customer_index',compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $customer = new Customer;
        return view('customer_form', compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request);
       $this->validate($request, [
            'name'=>'required',
            'phone'=>'required',
            'email'=>'required|email|unique:customers',
            'ic'=>'required|max:12',
            'attachment_ic' =>'nullable| mimes:pdf,png,jpg,bmp|max:5000',

        ]);

        $customer = new Customer;

        $customer->name = $request['name'];
        $customer->phone = $request['phone'];
        $customer->email = $request['email'];
        $customer->ic = $request['ic'];

        if($request->has('attachment_ic')){

            $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/customer_ic";
                if(!file_exists($directory)){
                    mkdir($directory, 0755, true);    
                }

                $file_name = "ic_".$request['ic']."_".time().".".$request->attachment_ic->getClientOriginalExtension();
                $file = $request->attachment_ic;
                $file->move($directory, $file_name);
                $customer->attachment_ic = "uploads/customer_ic/" .$file_name;
        }else{
            
            $customer->attachment_ic = ""; 
        }

        $customer->save();

        return redirect()->route('customer.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {

        $path =  $_SERVER['DOCUMENT_ROOT']."/" .$customer->attachment_ic;
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::stream(function() use($file) {
          echo $file;
        }, 200, ["Content-Type"=> $type]);

         return $response;
        // return $path;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
       //dd($customer);
        return view('customer_form', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
         $this->validate($request, [
            'name'=>'required',
            'phone'=>'required',
            // 'email'=>'required|email|unique:customers,email,'.$customer->id,
            'ic'=>'nullable|max:12',
            'attachment_ic'=>' mimes:pdf,png,jpg,bmp|max:5000',

        ]);

        $customer->name = $request['name'];
        $customer->phone = $request['phone'];
        $customer->email = $request['email'];
        $customer->ic = $request['ic'];

         if($request->hasFile('attachment_ic'))

         {
            $directory = $_SERVER['DOCUMENT_ROOT']. "/uploads/customer_ic";
           if(!file_exists($directory)){
                mkdir($directory, 0755, true);    
            }

         $file_name = "ic_".$customer->ic."_".time().".".$request['attachment_ic']->getClientOriginalExtension();
         $file = $request['attachment_ic'];
         $file->move($directory, $file_name);
         $customer->attachment_ic = "uploads/customer_ic/" .$file_name;

         }

        $customer->save();

        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return redirect()->route('customer.index');
    }
}

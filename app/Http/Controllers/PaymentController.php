<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PaymentExport;
use App\Customer;
use App\Booking;
use App\Payment;
use Toyyibpay;

class PaymentController extends Controller
{
    /* Function to display list of bank
     */
    public function getBanksFPX()
    {
        $data = Toyyibpay::getBanksFPX();

    }

    /* Function to create payment bill and bill code
     */
    public function createPaymentBill(Request $request, Customer $customer)
    {
   
        $code = config('toyyibpay.code');

        $booking = Booking::where('customer_id', $customer->id)->latest('created_at')->first();

        $amount = $booking->amount * 100;

        $bill_object = [
                'billName'=> 'Ventura Trans and Services',
                'billDescription'=> 'Bil No :'.''.$booking->booking_no ,
                'billPriceSetting'=> 1,
                'billPayorInfo'=> 1,
                'billAmount'=> $booking->amount * 100,

                'billReturnUrl'=> route('payment.status'), 
                'billCallbackUrl'=> route('payment.callback'),

                'billExternalReferenceNo' => $booking->booking_no,
                'billTo'=> $booking->customer()->name,
                'billEmail'=> $booking->customer()->email,
                'billPhone'=> $booking->customer()->phone,
                'billPaymentChannel' => 0,

                // 'billSplitPayment'=> $bill_object->billSplitPayment ?? 0,
                // 'billSplitPaymentArgs'=> $bill_object->billSplitPaymentArgs ?? '',
                // 'billPaymentChannel'=> $bill_object->billPaymentChannel ?? '0',
                // 'billContentEmail'=> $bill_object->billContentEmail ?? '',
                // 'billChargeToCustomer'=> $bill_object->billChargeToCustomer ?? 1,
        ];


        $data = Toyyibpay::createBill($code, (object)$bill_object);

        $bill_code = $data[0]->BillCode;

        $booking->payment_link = $bill_code;
        $booking->save();

        // dd($data);
        return redirect()->route('payment.bill-payment', $bill_code);
 
    }

    /* Function to route to toyyip gateway interface
     */
    public function billPaymentLink($bill_code)
    {
        $data = Toyyibpay::billPaymentLink($bill_code);

        return redirect($data);
        // dd($data);
    }

    /* Function to update status payment
     */
    public function paymentStatus()
    {
        $data = request()->all(['status_id', 'billcode', 'order_id', 'transaction_id']);
        $refno = isset($data['refno']) ? $data['refno'] : null;
    
        $booking = Booking::all()
            ->where('booking_no', $data['order_id'])
            ->first();

        // Update booking status based on payment status
        if ($data['status_id'] == 1) {
            $booking->booking_status = 'PAID';
        } elseif ($data['status_id'] == 2) {
            $booking->booking_status = 'PENDING';
        } elseif ($data['status_id'] == 3) {
            $booking->booking_status = 'PENDING';
        }
    
        //Store payment in the database
        if ($pay = Payment::where('booking_id', $booking->id )->exists()){
            
            Payment::findOrFail($booking->id)->update(['status' => $data['status_id']]);

        }else{
            Payment::create([
                'customer_id' => $booking->customer_id,
                'booking_id' => $booking->id,
                'amount' => $booking->amount,
                'mode' => 'FPX',
                'status' => $data['status_id'],
                'ref' => $data['transaction_id'],
                'receipt' => $refno,
                'payment_date' => now()->toDateString(),
                'payment_time' => now()->toTimeString(),
            ]);
        };
        
        $booking->save();
    
        return view('receipt', compact('booking', 'data'));
        $mergeArray = array_merge($booking, array($data));
        
        return $mergeArray;
    }

    /* Function to callback payment 
    */
    public function callback(Request $request)
    {
        $data = request()->all(['refno','status','reason','billcode','order_id','amount']);
        dd($data);
    }

    /*******************************************************************************************/
    /* CRUD Payment */
     /*******************************************************************************************/

    /* Function to search and display list of payment
     */
    public function index(Request $request)
    {
        // $search = $request->input('search');

        // $paymentsQuery = Payment::join('customers', 'customers.id', '=', 'payments.customer_id')
        //     ->join('bookings', 'bookings.id', '=', 'payments.booking_id')
        //     ->orderBy('booking_no', 'DESC');

        // if ($search) {
        //     $paymentsQuery->where(function ($query) use ($search) {
        //         $query->where('name', 'like', '%' . $search . '%')
        //             ->orWhere('booking_no', 'like', '%' . $search . '%')
        //             ->orWhere('mode', 'like', '%' . $search . '%')
        //             ->orWhere('payments.amount', 'like', '%' . $search . '%')
        //             ->orWhere('status', 'like', '%' . $search . '%');
                
        //         if ($search == 'success') {
        //             $query->orWhere('status', '1');
        //         } elseif ($search == 'unsuccessful') {
        //             $query->orWhere('status', '<>', '1');
        //         }
        //     });
            
        // }

        // $payments = $paymentsQuery->paginate(15);
        // $payments->appends($request->all());

        // return view('payment_index', compact('payments'));

        if($request->has('search')){

            $search = $request->search; 

            $paymentsQuery = Payment::join('customers', 'customers.id', '=', 'payments.customer_id')
                                ->join('bookings', 'bookings.id', '=', 'payments.booking_id')
                                ->orderBy('booking_no', 'DESC');

            $paymentsQuery->where(function ($query) use ($search) {
                  $query->where('customers.name','like','%'.$search. '%') 
                        ->orwhere('bookings.booking_no','like','%'.$search. '%') 
                        ->orwhere('payments.amount','like','%'.$search. '%')
                        ->orwhere('mode','like','%'.$search. '%')
                        ->orWhere('status','like','%'.$search. '%');

                    if ($search =='success'){
                        $query->orWhere('status','1');
                    }else if($search == 'unsuccessful'){
                        $query->orWhere('status','<>','1');
                    }

            });           
                                  
            $payments = $paymentsQuery->paginate(15);
            $payments->appends($request->all());
                   
        }
        
        else{

             $payments = Payment::join('customers', 'customers.id', '=', 'payments.customer_id')
                                ->join('bookings', 'bookings.id', '=', 'payments.booking_id')
                                ->orderBy('booking_no', 'DESC')
                                ->paginate(10);                        
        }
       
        return view('payment_index',compact('payments'));
    }

    /* Function to export list of payment in csv 
        */ 
        public function export()
        {
            return Excel::download(new PaymentExport, 'payments.xlsx');
        }

    /* Function to display receipt after payment success or not
     */
    public function show($pay_id)
    {
        $payment = Payment::where('booking_id',$pay_id)->first();
        // dd($payment);
        return view('payment_view', compact('payment'));
    }
   
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Notifications\BooksNotification;
// use App\Exports\BookingExport;
use Carbon\Carbon;
use App\User;
use App\Booking;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


/*route for Homepage Website*/
Route::get('/', function () {
    return view('welcome');
})->name('homepage');

/*route for Public Booking Controller*/
Route::get('/booking', 'PublicBookingController@index')->name('public.booking');
Route::post('/booking', 'PublicBookingController@post')->name('public.booking.post');
Route::get('/booking/success', 'PublicBookingController@success')->name('public.booking.success');
Route::get('/payment/banks/FPX', 'PaymentController@getBanksFPX')-> name('payment.banks');
Route::get('/payment/gateway/{customer}', 'PaymentController@createPaymentBill')-> name('payment.create-payment');
Route::get('/payment/bill/{bill_code}', 'PaymentController@billPaymentLink')-> name('payment.bill-payment');
Route::get('/payment/status', 'PaymentController@paymentStatus')-> name('payment.status');
Route::post('/payment/callback', 'PaymentController@callback')-> name('payment.callback');
Route::get('/payment/receipt', 'PaymentController@paymentStatus')->name('payment.receipt');


/*route for login user*/
Auth::routes();

/*route for Group Admin Controller*/
Route::group(['prefix'=> 'admin'], function(){

    /*route for Dashboard Controller*/
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('/markasread/{id}','HomeController@markasread')->name('markasread');
    // Route::get('chart-book', 'HomeController@generateChart')->name('chart-book');
    // Route::get('chart', 'HomeController@index')->name('chart');

    /*route for function CRUD Controller*/
    Route::resource('staff', 'StaffController');
    Route::resource('customer', 'CustomerController');
    Route::resource('location', 'LocationController');
    Route::resource('vehicle', 'VehicleController');
    Route::resource('shipment', 'ShipmentController');
    Route::resource('booking', 'BookingController');
    Route::resource('package', 'PackageController');
    Route::resource('insurance', 'InsuranceController');
    Route::resource('payment', 'PaymentController');

    // Route::resource('chart', 'ChartController');

    /*route for function upload img path in Controller*/
    Route::get('vLinkFileGrant/{id}', 'VehicleController@vLinkFileGrant')->name('vehicle.vLinkFileGrant');
    Route::get('vLinkFileLoan/{id}', 'VehicleController@vLinkFileLoan')->name('vehicle.vLinkFileLoan');
    Route::get('linkFileGrant/{id}', 'BookingController@linkFileGrant')->name('booking.linkFileGrant');
    Route::get('linkFileLoan/{id}', 'BookingController@linkFileLoan')->name('booking.linkFileLoan');
    Route::get('linkFileID/{id}', 'BookingController@linkFileID')->name('booking.linkFileID');

    /*route for function showView Booking in Controller*/
    /* show Quotation using function booking.show */
    Route::get('booking/invoice/{id}',  'BookingController@showInvoice')->name('booking.showInvoice');
    Route::get('booking/receipt/{id}',  'BookingController@showReceipt')->name('booking.showReceipt');
    Route::get('booking/confirmation/{id}',  'BookingController@showConfirm')->name('booking.showConfirm');
    // Route::get('booking/{id}',  'BookingController@showQuote')->name('booking.showQuote');

    /*route for function create PDF file in Controller*/
    Route::get('booking/pdf/quote/{id}',  'BookingController@quotePDF')->name('booking.quotePDF');
    Route::get('booking/pdf/invoice/{id}',  'BookingController@invoicePDF')->name('booking.invoicePDF');
    Route::get('booking/pdf/receipt/{id}',  'BookingController@receiptPDF')->name('booking.receiptPDF');
    Route::get('booking/pdf/confirm/{id}',  'BookingController@confirmPDF')->name('booking.confirmPDF');
    
    /*route for function export to csv*/
    Route::get('/export-bookings', 'BookingController@export')->name('export.bookings');
});

/*route for JS Dynamic Dropdown (Booking) function in Controller*/
Route::get('/admin/booking/fetch_dd/{id}', 'DropdownController@fetchPickup');
Route::get('/admin/booking/fetch_trip/{id}', 'DropdownController@fetchTrips');
Route::get('/admin/booking/fetch_ship/{id}', 'DropdownController@fetchShip');
Route::get('/admin/booking/pickupPrice/{id}', 'DropdownController@pickupPrice');
Route::get('/admin/booking/deliveryPrice/{id}', 'DropdownController@deliveryPrice');
Route::get('/admin/booking/insurancePrice/{id}', 'DropdownController@insurancePrice');
Route::get('/admin/booking/fetch_cust/{id}', 'DropdownController@fetchCust');
Route::get('/admin/booking/fetch_model/{id}', 'DropdownController@fetchModel');






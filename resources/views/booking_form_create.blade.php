@extends('layouts.master')
@section('content')

<div x-data="{show: true}" x-init="setTimeout(() => show = false, 5000)" x-show="show">
@if(!empty($successMsg))
 <div class="alert alert-success"> {{ $successMsg }}</div>
@else
    @foreach($errors->all() as $error)
    <div class="alert alert-danger">
        {{  $error }}
    </div>
    @endforeach
@endif
</div>


<?php

$action = route('booking.store');

$method = 'POST';
?>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 


<div class="row">
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Vehicle Owner's Details</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <input type="hidden" name="keyin" value="{{ Auth::user()->id }}" class="form-control" >

                <div class="form-group">
                    <label>Select Customer</label>
                    <select class="form-control" id="cust-dropdown">
                        <option>PLEASE SELECT</option>
                            @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}" @if(old('id') == $customer->id) selected @endif >{{ $customer->name }} </option>
                            @endforeach
                    </select> 
                </div>  

                <input type="hidden" name="cust_id" id="cust-id" class="form-control" >

                <div class="form-group" id="custname">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" id="cust-name" class="form-control" style="text-transform: uppercase;" placeholder=" Husna XXXXX">
                </div>

                <div class="form-group">
                    <label>Contact No.</label>
                    <input type="text" name="contact" value="{{ old('phone')}}" id="cust-phone" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="013XXXXXXX">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" value="{{ old('email')}}" id="cust-email" class="form-control" style="text-transform: lowercase;" placeholder="husna@xxxxx.com">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                        <label>ID No.</label>
                        <input type="text" name="ic_no" value="{{ old('ic')}}" id="cust-ic" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="XXXXXXXXXXXX">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        <label>Attachement ID</label>
                        <input type="file" name="attachment_ic" id="formFile" class="border-0" >
                        </div>
                    </div>
                        <div class="form-group" style="color:red;padding-left: 20px;"><br>
                    
                            <label>Vehicle Categories :</label>
                            <p>
                                Light Commercial Car = SUV, MPV, Pickup 4x4 <br>
                                Passanger Car = Sedan, Hatchback, Compact <br>
                                Motorcyles = All types of Motorcycle 
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Booking Details</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">

                        <div class="form-group">
                        
                               <label>Vehicle Category</label>
                                <select class="form-control" name="vehicle_category" id="car-cat-dropdown">
                                   <option>PLEASE SELECT</option>
                                        @foreach ($packages as $package)
                                        <option value="{{ $package->car_category }}" @if(old('car_category') == $package->car_category) selected @endif >{{ $package->car_category }} </option>
                                        @endforeach
                                </select> 
                        </div>  

                        <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group">
                                    
                                           <label>Shipment Trip</label>
                                            <select class="form-control" name="shipment_trip" id="trip-dropdown">
                                               <option>PLEASE SELECT</option>
                                            </select> 
                                    </div>
                                </div>

                                <div class="col-md-5">

                                    <div class="form-group">
                                        
                                        <label>Options</label>
                                        <select class="form-control" id="options" name="options"  >
                                        <option value="0">PLEASE SELECT</option>
                                        <option value="1">PORT TO PORT</option>
                                        <option value="2">PORT TO DOOR</option>
                                        <option value="3">DOOR TO PORT</option>
                                        <option value="4">DOOR TO DOOR</option>
                                        </select>

                                     </div>
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                        <label>Shipment Date</label>
                                        <select class="form-control" name="shipment_date" id="ship-dropdown">
                                           <option>PLEASE SELECT</option>
                                        </select>
                                </div>
                            </div>
                             <div class="col-md-5">
                                
                            </div>
                             <div class="col-md-5">
                               
                            </div>
                        </div>

                       
                        <div class="row" id="pick-delivery">
                            <div class="col-md-6" id="hidden-pickup" style="display: none;">

                                <div class="form-group">
                                    <label>Pickup Carrier</label>
                                       <select class="form-control"  name="carry_by" id="pickup-carrier"  >
                                            <option >PLEASE SELECT</option>
                                             @foreach ($locations as $location)
                                             <option value="{{ $location->carry_by }}" @if(old('carry_by') == $location->carry_by) selected @endif >{{ $location->carry_by }} </option>
                                             @endforeach
                                        </select>
                                </div>

                                <div class="form-group">
                                    <label>Pickup Location </label>
                                        <select class="form-control" name="pickup_location" id="pickup-dropdown">
                                             <option>PLEASE SELECT</option>
                                        </select>
                                </div>
                            </div>
                            <div class="col-md-6" id="hidden-delivery" style="display: none;">

                                <div class="form-group">
                                    <label>Delivery Carrier</label>
                                       <select class="form-control"  name="carry_by" id="delivery-carrier"  >
                                            <option >PLEASE SELECT</option>
                                             @foreach ($locations as $location)
                                             <option value="{{ $location->carry_by }}" @if(old('carry_by') == $location->carry_by) selected @endif >{{ $location->carry_by }} </option>
                                             @endforeach
                                        </select>
                                </div>

                                <div class="form-group">
                                    <label>Delivery Location</label>
                                        <select class="form-control" name="delivery_location" id="delivery-dropdown">
                                            <option>PLEASE SELECT</option>
                                        </select>
                                </div>
                            </div>

                        </div>

                        <div class="row" id="marine" >
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label>Marine Insurance </label>
                                        <div class="custom-control custom-switch">
                                              <input type="checkbox" class="custom-control-input" id="customSwitches">
                                              <label class="custom-control-label" for="customSwitches">Yes</label>
                                        </div>
                                </div>
                            </div>

                            <div class="col-md-6" id="marine-dropdown" style="display:none;">
                                <div class="form-group">
                                        <label>Vehicle Market Value </label>
                                        <select class="form-control" name="vehicle_market_value" id="market_value">
                                            <option value="">PLEASE SELECT</option>
                                             @foreach ($insurances as $insurance)
                                            <option value="{{ $insurance->id }}" @if(old('insurance_id') == $insurance->id) selected @endif >RM{{ number_format($insurance->market_value,0,".",",") }} </option>
                                            @endforeach
                                        </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                  <div class="form-group">
                                        <label>Total</label>
                                        <input type ="text" class="border-0" id ="total_price" name="total_price" readonly>
                                  </div>
                            </div>
                        </div>

                       <!--  <div class="col-md-6">
                              <div class="form-group">
                                    <label>Total</label>
                                    <input type ="text" class="border-0" id ="total_price" name="total_price" >
                              </div>
                        </div> -->

                         <!-- <div class="col-md-6">
                              <div class="form-group">
                                    <label>Discount</label>
                                    <input type ="text" class="form-control" id ="discount" name="discount">
                              </div>

                        </div>

                         <div class="col-md-6">
                              <div class="form-group">
                                    <label>Price After Discount</label>
                                    <input type ="text" class="form-control" id ="price_after" name="price_after" readonly>
                              </div>

                        </div>
 -->            
                <br>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Vehicle Details</h6>   
            </div>
            <!-- Card Body -->
            <div class="card-body">
                    

                <!-- <input type="text" name="id" id="model" class="form-control" > -->
                <div class ="row">
                    <div class ="col-md-6">
                        <div class="form-group">
                            <label>Brand</label>
                            <select class="form-control" id="make-dropdown">
                            <option>PLEASE SELECT</option>
                                @foreach ($model_vehicles as $model)
                                <option value="{{ $model->make }}" @if(old('make') == $model->make) selected @endif >{{ strtoupper($model->make) }} </option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class="form-group">          
                            <label>Model</label>
                            <select class="form-control" name="model_id" id="model-dropdown">
                                <option>PLEASE SELECT</option>
                            </select> 
                        </div>
                    </div>
                </div>   
                <div class ="row" id="insert-vehicle">
                    <div class ="col-md-5">
                        <div class="form-group">          
                            <label>Model</label>
                            <input type="text" name="model" id="" class="form-control" style="text-transform: uppercase;" placeholder="TOYOTA">   
                        </div>
                    </div>
                    <div class ="col-md-3">
                        <div class="form-group">
                            <label>Year</label>
                            <input type="text" name="year"  id="" class="form-control" style="text-transform: uppercase;" placeholder="20XX">
                        </div>
                    </div>
                    <div class ="col-md-4">
                        <div class="form-group">
                            <label>Body Type</label>
                            <div class="form-group">
                                <select class="form-control" name="body_type">
                                <option value="">PLEASE SELECT</option>
                                <option value="SEDAN">SEDAN</option>
                                <option value="MPV">MPV</option>
                                <option value="SUV">SUV</option>
                                <option value="MOTORCYCLE">MOTORCYCLE</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class ='row'>    
                    <div class ="col-md-6">    
                        <div class="form-group">
                            <label>Vehicle Regist No. </label>
                            <input type="text" class="form-control" name="vehicle_registration_no" value="{{ old('plate_no') }}" style="text-transform: uppercase;" placeholder="JHJ2019">
                        </div>
                    </div>
                    <div class ="col-md-6">
                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="color" value="{{ old('color')}}" class="form-control" style="text-transform: uppercase;">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Engine No.</label>
                            <input type="text" name="engine_no" value="{{ old('engine')}}" class="form-control" style="text-transform: uppercase;">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Chasis No.</label>
                            <input type="text" name="chasis_no" value="{{ old('chasis')}}" class="form-control" style="text-transform: uppercase;">
                        </div>
                    </div>
                </div>
                    <!-- <div class="form-group">
                        <label>Model </label>
                        <input type="text" class="form-control" name="model" value="{{ old('model') }}" style="text-transform: uppercase;" placeholder="TOYOTA">
                    </div> -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Attachement Grant</label><br>
                                <input type="file" name="attachment_geran" id="formFile" class="border-0" >
                            </div>     
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label>Attachement Bank Letter</label><br>
                                <input type="file" name="attachment_bank" id="formFile" class="border-0" >
                            </div>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks </label>
                                <textarea class="form-control" name="notes" value="{{ old('notes') }}" style="text-transform: uppercase;"></textarea> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Personal Effect </label>
                                <textarea class="form-control" name="personal_effect" value="{{ old('personal_effect') }}" style="text-transform: uppercase;"></textarea> 
                            </div>
                        </div>     
                    </div>              
            </div>
        </div>
    </div>
</div>

    <div class="form-group">
                  <a href="{{route('booking.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i> &nbsp;Cancel</a>
                            
                  <button type="submit" name="save" value="save" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp;Save</a></button>
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-credit-card"></i>&nbsp;Payment</a></button>
    </div> 

</form>

 <script src="{{ asset('js/booking.js') }}" defer></script>


@endsection
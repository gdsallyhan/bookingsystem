@extends('layouts.app')

@section('content')

<h1>Booking Page</h1>
<br>

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

   $action = route('public.booking.post');

   $method = 'POST';

?>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" id="bookForm">
<input type="hidden" name="_method" value="{{ $method }}">
                    
@csrf 

<!-- start step indicators -->
        <div class="form-header">
            <span class="stepIndicator">Vehicle Owner Information</span>
            <span class="stepIndicator">Vehicle Information</span>
            <span class="stepIndicator">Booking Information</span>
            
        </div>
          <!-- end step indicators -->

        <br>

 <div class="row justify-content-center">
    <div class="step">
        <div class="col-md-12">
            <div class="card">
            	<div class="card-header">Vehicle Owner's Details</div>
                

                    <div class="card-body">

                    	<div class="form-group">
                    	
                    	<label>Name</label>
                    	<input type="text" name="name" value="{{ old('name')}}" class="form-control" style="text-transform: uppercase;" placeholder=" Husna">
                   		 </div>

                    	<div class="form-group">
                    	<label>Contact No. </label>
                    	<input type="text" name="contact" value="{{ old('phone')}}" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" placeholder="013XXXXXXX">
                    	</div>

                    	<div class="form-group">
                    	<label>Email</label>
                    	<input type="text" name="email" value="{{ old('email')}}" class="form-control" style="text-transform: lowercase;" placeholder="husna@xxxxx.com">
                    	</div>

                        <div class="row">
                            <div class="col-md-6">
                            	<div class="form-group">
                                	<label>ID No.</label>
                                	<input type="text" name="id_no" value="{{ old('ic')}}" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="XXXXXXXXXXXX">
                            	</div>
                            </div>

                            <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Attachment ID</label>
                                    <input type="file" class="form-control" name="attachment_ic" >
                                </div>
                            </div>

                        </div>

                    
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row justify-content-center">
    <div class="step">
         <div class="col-md-12">
            <div class="card">
                <div class="card-header">Booking Details</div>

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
                                <div class="col-md-6">
                                    <div class="form-group">
                                    
                                           <label>Shipment Trip</label>
                                            <select class="form-control" name="shipment_trip" id="trip-dropdown">
                                               <option>PLEASE SELECT</option>
                                            </select> 
                                    </div>
                                </div>

                                <div class="col-md-6">
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

                        <div class="form-group">
                        
                                <label>Shipment Date</label>
                                <select class="form-control" name="shipment_date" id="ship-dropdown">
                                   <option>PLEASE SELECT</option>
                                </select>
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
                                                <option value="{{ $insurance->id }}" @if(old('insurance_id') == $insurance->id) selected @endif >RM{{ number_format($insurance->market_value,0,".",",") }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                            </div>
                        </div>

                        <div class="row">
                        <div class="col-md-1">
                              <div class="form-group">
                                    <label>Total</label>
                              </div>
                        </div>
                        <div class="col-md-2">
                              <div class="form-group">
                                    <input type ="text" class="border-0" id ="total_price" name="total_price" readonly>
                              </div>
                        </div>
                        </div>

                    </div>
            </div>

        </div>
    </div>
</div>
    
<br>
<div class="row justify-content-center">
    <div class="step">
         <div class="col-md-12">
            <div class="card">
            	<div class="card-header">Vehicle Details</div>
                

                <div class="card-body">

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
                            <label>Body Color</label>
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
                        	<label>Body Type</label>
                        	<select class="form-control" name="body_type">
                            <option value="">PLEASE SELECT</option>
                        	<option value="SEDAN">SEDAN</option>
                        	<option value="MPV">MPV</option>
                        	<option value="SUV">SUV</option>
                        	<option value="MOTORCYCLE">MOTORCYCLE</option>
                       		 </select>
                   		 </div>

                    	<div class="form-group">
                        	<label>Vehicle Registration No. </label>
                        	<input type="text" class="form-control" name="vehicle_registration_no" value="{{ old('plate_no') }}" style="text-transform: uppercase;" placeholder="JHJ2019">
                    	</div>

                    	<div class="form-group">
                        	<label>Model </label>
                        	<input type="text" class="form-control" name="model" value="{{ old('model') }}" style="text-transform: uppercase;" placeholder="TOYOTA">
                    	</div> -->


                    <div class="row">
                            <div class="col-md-6">
                            	<div class="form-group">
                                	<label>Attach Grant</label>
                                	<input type="file" class="form-control" name="attachment_geran" >
                            	</div>
                            </div>

                            <div class="col-md-6">
                            	<div class="form-group">
                                	<label>Attach Bank Letter / Insurance Policies</label>
                                	<input type="file" class="form-control" name="attachment_bank" >
                            	</div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

      
</div>

    <!-- <div class="form-group">
          <a href="{{route('homepage')}}" class="btn btn-danger"><i class="icon-arrow-left"></i> &nbsp; Cancel</a>
	              	
          <button type="submit" class="btn btn-primary"><i class="icon-save"></i>&nbsp; Save</a></button>
	</div> -->

    <div class="form-footer">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
    </div>

 </form>

 

 <script src="{{ asset('js/booking.js') }}" defer></script>

@endsection
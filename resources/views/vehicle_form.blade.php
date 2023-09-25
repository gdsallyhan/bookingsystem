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

$action = $vehicle->id ? route('vehicle.update', $vehicle->id) : route('vehicle.store');

$method = $vehicle->id ? 'PUT' : 'POST';
?>

 <form method="POST" action="{{ $action }}">
 <input type="hidden" name="_method" value="{{ $method }}">
 @csrf 


 <div class="row">

        <div class="col-xl-5 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Vehicle Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                        <div class="form-group">
                            <label>Booking No.</label>
                            <input type="text" name="booking_no" value="{{ old('booking_no', $vehicle->booking()->booking_no )}}" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Customer Name</label>
                            <input type="text" name="id" value="{{ old('name', $vehicle->customer()->name )}}" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Brand</label>
                            <select class="form-control" id="make-dropdown">
                            <option>PLEASE SELECT</option>
                                @foreach ($model_vehicles as $model)
                                <option value="{{ $model->make }}" @if(old('make') == $model->make) selected @endif >{{ strtoupper($model->make) }} </option>
                                @endforeach
                            </select> 
                        </div>

                        <div class="form-group">          
                            <label>Model</label>
                            <select class="form-control" name="model_id" id="model-dropdown">
                                <option>PLEASE SELECT</option>
                            </select> 
                        </div>

                        <div class="form-group">
                            <label>Personal Effect</label>
                             <textarea name="personal_effect" value="" class="form-control">{{ old('personal_effect', $vehicle->personal_effect )}}</textarea>
                        </div>

                </div>
            </div>
        </div>

        <div class="col-xl-5 col-lg-4">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">&nbsp;</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                        <div class="form-group">
                            <label>Plate No.</label>
                            <input type="text" name="plate_no" value="{{ old('plate_no', $vehicle->plate_no )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Engine No.</label>
                            <input type="text" name="engine" value="{{ old('engine', $vehicle->engine )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Chasis No.</label>
                            <input type="text" name="chasis" value="{{ old('chasis', $vehicle->chasis )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="color" value="{{ old('color', $vehicle->color )}}" class="form-control">
                        </div>

                         <div class="form-group">
                            <label>Year</label>
                            <select class="form-control" name="year">
                            @if($vehicle->year == '')
                                <option>Please Select</option>
                            @else
                                <option >{{ $vehicle->year }}</option>
                            @endif
                            @for ($i = 1980; $i < 2050; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                            </select>
                        </div>

                </div>
            </div>
        </div>

</div>

        <div class="form-group">
                  <a href="{{route('vehicle.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
        </div>

</form>
                    
<script src="{{ asset('js/booking.js') }}" defer></script>   

@endsection
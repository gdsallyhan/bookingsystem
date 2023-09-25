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

$action = $package->id ? route('package.update', $package->id) : route('package.store');

$method = $package->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 

    <div class="row">

        <div class="col-xl-5 col-lg-4">
            
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Package Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">


                        <div class="form-group">
                        <label>Car Category </label>
                        <select class="form-control" name="car_category">
                            <option>Please Select</option>
                            <option value="PASSANGER CAR" @if(old('car_category', $package->car_category) == 'PASSANGER CAR') selected @endif>PASSANGER CAR</option>
                            <option value="LIGHT COMMERCIAL CAR" @if(old('car_category', $package->car_category) == 'LIGHT COMMERCIAL CAR') selected @endif>LIGHT COMMERCIAL CAR</option>
                            <option value="MOTORCYCLE" @if(old('car_category', $package->car_category) == 'MOTORCYCLE') selected @endif>MOTORCYCLE</option>
                            
                        </select>
                        </div>

                        <div class="form-group">
                        
                            <label>Trip</label>

                                <div class="row">
                                    <div class="col-md-6">
                                            <input type="text" name="trip_from" value="{{ old('trip_from', $package->trip_from )}}" class="form-control">
                                    </div>
                                    
                                    <div class="col-md-6">        
                                            <input type="text" name="trip_to" value="{{ old('trip_to', $package->trip_to )}}" class="form-control">
                                    </div>
                                </div>
                         </div>

                         <div class="form-group">
                            <label>Price</label>
                            <input type="text" name="price" value="{{ old('price', $package->price )}}" class="form-control">
                         </div>
                       

                </div>
            </div>

            <div class="form-group">
                  <a href="{{route('package.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
            </div>

        </div>
    </div>

</form>


@endsection
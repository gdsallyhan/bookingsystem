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

$action = $insurance->id ? route('insurance.update', $insurance->id) : route('insurance.store');

$method = $insurance->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 

    <div class="row">

        <div class="col-xl-5 col-lg-4">
            
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Insurance Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                        <div class="form-group">
                            <label>Vehicle Market Value</label>
                            <input type="text" name="market_value" value="{{ old('market_value', $insurance->market_value )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Marine Insurance Price </label>
                            <input type="text" name="insurance_price" value="{{ old('insurance_price', $insurance->insurance_price )}}" class="form-control">
                        </div>

                </div>
            </div>

            <div class="form-group">
                  <a href="{{route('insurance.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
            </div>

        </div>
    </div>

</form>


@endsection
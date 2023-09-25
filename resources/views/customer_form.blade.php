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

$action = $customer->id ? route('customer.update', $customer->id) : route('customer.store');

$method = $customer->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 


    <div class="row">

        <div class="col-xl-5 col-lg-4">
            
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" value="{{ old('name', $customer->name )}}" class="form-control">
                         </div>

                        <div class="form-group">
                            <label>Phone </label>
                            <input type="text" name="phone" value="{{ old('phone', $customer->phone )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" value="{{ old('email', $customer->email )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>ID Number</label>
                            <input type="text" name="ic" value="{{ old('ic', $customer->ic )}}" class="form-control">
                        </div>

                    
                        <div class="form-group">
                            <label>Attachement ID</label>
                            <input type="file" class="form-control" name="attachment_ic" id="formFile" >
                        </div>

                </div>
            </div>

            <div class="form-group">
                  <a href="{{route('customer.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
            </div>

        </div>
    </div>

</form>

@endsection
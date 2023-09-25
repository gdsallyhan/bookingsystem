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

   $action = $shipment->id ? route('shipment.update', $shipment->id) : route('shipment.store');

   $method = $shipment->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf

 <div class="row">

        <div class="col-xl-5 col-lg-4">
            
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Shipment Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                        <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" value="{{ old('date', $shipment->date )}}" class="form-control" >
                                 </div>
                                
                                <div class="form-group">
                                    <label>Ship Name</label>
                                    <input type="text" name="name" value="{{ old('name', $shipment->name )}}" class="form-control">
                                 </div>

                                <div class="form-group">
                                    <label>Ship No.</label>
                                    <input type="text" name="number" value="{{ old('number', $shipment->number )}}" class="form-control">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-6">
                                        <label>Port From</label>
                                        <select class="form-control" name="port_from">
                                            <option>Please Select</option>
                                            <option value="PORT KLANG" @if(old('port_from', $shipment->port_from) == 'PORT KLANG') selected @endif>PORT KLANG</option>
                                            <option value="PORT KUCHING" @if(old('port_from', $shipment->port_from) == 'PORT KUCHING') selected @endif>PORT KUCHING</option>
                                            <option value="PORT KOTA KINABALU" @if(old('port_from', $shipment->port_from) == 'PORT KOTA KINABALU') selected @endif>KOTA KINABALU</option>
                                        </select>
                                        </div>
                            
                                        <div class="col-md-6">
                                                <label>Port To</label>
                                                <select class="form-control" name="port_to">
                                                    <option>Please Select</option>
                                                    <option value="PORT KLANG" @if(old('port_to', $shipment->port_to) == 'PORT KLANG') selected @endif>PORT KLANG</option>
                                                    <option value="PORT KUCHING" @if(old('port_to', $shipment->port_to) == 'PORT KUCHING') selected @endif>PORT KUCHING</option>
                                                    <option value="PORT KOTA KINABALU" @if(old('port_to', $shipment->port_to) == 'PORT KOTA KINABALU') selected @endif>KOTA KINABALU</option>
                                                </select>
                                        </div>
                                    </div>
                                </div>
                        

                </div>
            </div>

            <div class="form-group">
                  <a href="{{route('shipment.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
            </div>

        </div>
    </div>


</form>

@endsection



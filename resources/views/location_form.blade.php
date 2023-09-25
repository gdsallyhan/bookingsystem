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

$action = $location->id ? route('location.update', $location->id) : route('location.store');

$method = $location->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 

  <div class="row">

        <div class="col-xl-5 col-lg-4">
            
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Location Details</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">

                     <div class="form-group">
                            <label>Location Name</label>
                            <input type="text" name="name" value="{{ old('name', $location->name )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>State </label>
                            <select class="form-control" name="state">
                                <option>Please Select</option>
                                <option value="PERLIS" @if(old('state', $location->state) == 'PERLIS') selected @endif>PERLIS</option>
                                <option value="KEDAH" @if(old('state', $location->state) == 'KEDAH') selected @endif>KEDAH</option>
                                <option value="PERAK" @if(old('state', $location->state) == 'PERAK') selected @endif>PERAK</option>
                                <option value="KELANTAN" @if(old('state', $location->state) == 'KELANTAN') selected @endif>KELANTAN</option>
                                <option value="TERENGGANU" @if(old('state', $location->state) == 'TERENGGANU') selected @endif>TERENGGANU</option>
                                <option value="PAHANG" @if(old('state', $location->state) == 'PAHANG') selected @endif>PAHANG</option>
                                <option value="SELANGOR" @if(old('state', $location->state) == 'SELANGOR') selected @endif>SELANGOR</option>
                                <option value="NEGERI SEMBILAN" @if(old('state', $location->state) == 'NEGERI SEMBILAN') selected @endif>NEGERI SEMBILAN</option>
                                <option value="MELAKA" @if(old('state', $location->state) == 'MELAKA') selected @endif>MELAKA</option>
                                <option value="JOHOR" @if(old('state', $location->state) == 'JOHOR') selected @endif>JOHOR</option>
                                <option value="SABAH" @if(old('state', $location->state) == 'SABAH') selected @endif>SABAH</option>
                                <option value="SARAWAK" @if(old('state', $location->state) == 'SARAWAK') selected @endif>SARAWAK</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Port</label>
                            <select class="form-control" name="port">
                                <option>Please Select</option>
                                <option value="PORT KLANG" @if(old('port', $location->port) == 'PORT KLANG') selected @endif>PORT KLANG</option>
                                <option value="PORT KUCHING" @if(old('port', $location->port) == 'PORT KUCHING') selected @endif>PORT KUCHING</option>
                                <option value="PORT KOTA KINABALU" @if(old('port', $location->port) == 'PORT KOTA KINABALU') selected @endif>KOTA KINABALU</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                           <input type="text" name="price" value="{{ old('price', $location->price )}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Carrier Type</label>
                            <select class="form-control" name="carry_by">
                                <option>Please Select</option>
                                <option value="DRIVING" @if(old('carry_by', $location->carry_by) == 'DRIVING') selected @endif>DRIVING</option>
                                <option value="SINGLE CARRIER" @if(old('carry_by', $location->carry_by) == 'SINGLE CARRIER') selected @endif>SINGLE CARRIER</option>
                                 <option value="TRELLER" @if(old('carry_by', $location->carry_by) == 'TRELLER') selected @endif>TRELLER</option>
                            </select>
                        </div>   

                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="status">
                                <option>Please Select</option>
                                <option value="1" @if(old('status', $location->status) == '1') selected @endif>ACTIVE</option>
                                <option value="0" @if(old('status', $location->status) == '0') selected @endif>INACTIVE</option>
                            </select>
                        </div>   

                </div>
            </div>

            <div class="form-group">
                  <a href="{{route('location.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                            
                  <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
            </div>

        </div>
    </div>
</form>


@endsection
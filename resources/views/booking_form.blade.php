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

$action = $booking->id ? route('booking.update', $booking->id) : route('booking.store');
;

$method = $booking->id ? 'PUT' : 'POST';
?>

<form method="POST" action="{{ $action }}" enctype="multipart/form-data">
<input type="hidden" name="_method" value="{{ $method }}">
@csrf 


<div class="row">

    <div class="col-xl-6 col-lg-5">

        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Vehicle Owner's Details</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                       
                    
                        <table class="table">
                            <tr>
                                <th style="width:30%;">Name</th>
                               <!--  <td>: &nbsp;</td> -->
                                <td>{{$booking->customer()->name}}</td>
                            </tr>

                             <tr>
                                <th>Contact No.</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->customer()->phone}}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->customer()->email}}</td>
                            </tr>

                             <tr>
                                <th>ID No.</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->customer()->ic}}</td>
                            </tr>

                        </table>

            </div>
        </div>

        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Vehicle Details</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">

                   <table class="table">

                            <tr>
                                <th>Brand/Model</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{strtoupper($model_vehicles->make)}} {{strtoupper($model_vehicles->model)}}</td>
                            </tr>
                            <tr>
                                <th>Year Manufactured</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$model_vehicles->year}}</td>
                            </tr>
                            <tr>
                                <th>Body Type</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$model_vehicles->category}}</td>
                            </tr>
                             <tr>
                                <th style="width:30%;">Registration No</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->vehicle()->plate_no}}</td>
                            </tr>
                            <tr>
                                <th>Engine No.</th>
                               <!--  <td>: &nbsp;</td> -->
                                <td>{{$booking->vehicle()->engine}}</td>
                            </tr>
                            <tr>
                                <th>Chassis No.</th>
                               <!--  <td>: &nbsp;</td> -->
                                <td>{{$booking->vehicle()->chasis}}</td>
                            </tr>
                            <tr>
                                <th>Color</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->vehicle()->color}}</td>
                            </tr>
                            <tr>
                                <th>Approx Market Value</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>@if ($booking->insurance_id >0)
                                RM{{ number_format($booking->insurance()->market_value,2,".",",") }}
                                @else
                               
                                @endif</td>     
                            </tr>
                            <tr>
                                <th>Personal Effect</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->vehicle()->personal_effect}}</td>
                            </tr>
                            <tr>
                                <th>Remarks</th>
                                <!-- <td>: &nbsp;</td> -->
                                <td>{{$booking->notes}}</td>
                            </tr>
                        </table>      

            </div>
        </div>

        <div class="form-group">
              <a href="{{route('booking.index')}}" class="btn btn-danger"><i class="fas fa-fw fa-arrow-left"></i>&nbsp; Cancel</a>
                        
              <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-save"></i>&nbsp; Save</button>
        </div>

    </div>

    <div class="col-xl-6 col-lg-5">
        
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Booking Details</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">

                    <table class="table">

                        <tr>
                            <th style="width:20%;">Category</th>
                            <!-- <td>: &nbsp;</td> -->
                            <td>{{$booking->package()->car_category}}</td>
                        </tr>

                        <tr>
                            <th>Date</th>
                            <!-- <td>: &nbsp;</td> -->
                            <td>{{date('d F, Y', strtotime($booking->shipment()->date))}} {{$booking->shipment()->name}} {{$booking->shipment()->number}} </td>
                        </tr>

                        <tr>
                            <th>Trip</th>
                           <!--  <td>: &nbsp;</td> -->
                            <td>{{$booking->package()->trip_from}} - {{$booking->package()->trip_to}} <b>(RM{{number_format($booking->package()->price,2,".",",")}})</b></td>
                            
                        </tr>

                        <tr>
                            <th>Pickup</th>
                            <!-- <td>: &nbsp;</td> -->
                            <td>{{$booking->locationPickup()->name}} / {{$booking->locationPickup()->state}} <b>(RM{{ number_format($booking->locationPickup()->price,2,".",",") }})</b></td>
                        </tr>

                        <tr>
                            <th>Delivery</th>
                           <!--  <td>: &nbsp;</td> -->
                            <td>{{$booking->locationDelivery()->name}} / {{$booking->locationDelivery()->state}} <b>(RM{{ number_format($booking->locationDelivery()->price,2,".",",") }})</b></td>
                        </tr>

                        <tr>
                            <th>Marine Insurance</th>
                           <!--  <td>: &nbsp;</td> -->
                            <td>@if ($booking->insurance_id >0)
                            <b>RM{{ number_format($booking->insurance()->insurance_price,2,".",",") }}</b>
                            @else
                            
                            @endif</td>
                           
                        </tr>

                        <tr>
                            <th>Total Amount</th>
                            <!-- <td>: &nbsp;</td> -->
                            <td><b>RM{{ number_format($booking->amount,2,".",",") }}</b></td>
                           
                        </tr>
                    </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Attachment File</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="file" class="form-control" name="attachment_geran" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                  @if($booking->vehicle()->file_geran != '')
                                    <p><a href="{{route('booking.linkFileGrant', $booking->id)}}" target="_blank" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return true;" >*Vehicle's Registration Card is uploaded</a></p>

                                    @else
                                    <p>No Vehicle's Registration Card uploaded</p>

                                    @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="file" class="form-control" name="attachment_geran" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                  @if($booking->vehicle()->file_loan != '')
                                    <p><a href="{{route('booking.linkFileLoan', $booking->id)}}" target="_blank" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return true;" >*Bank Permission Letter/ Policies Insurance is uploaded</a></p>

                                    @else
                                    <p>No Bank Permission Letter/ Policies Insurance is uploaded</p>

                                    @endif
                            </div>
                        </div>
                         
                    </div>
                </div>         
            </div>
           
        </div>

        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Booking</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="form-group">
                        
                    <label>Shipment Date</label>
                    <select class="form-control" name="shipment_date" id="ship-dropdown">
                        <!-- <option>PLEASE SELECT</option> -->

                        @if(count($shipments) > 0)
                             @foreach ($shipments as $shipment)
                                  <option value="{{ $shipment->id }}" @if(old('shipment_id') == $shipment->id || $shipment->id == $booking->shipment_id ) selected @endif >{{ Carbon\Carbon::parse($shipment->date)->format('d F, Y') }} - {{ $shipment->name }} ({{ $shipment->port_from }} - {{ $shipment->port_to }})
                                  </option>
                             @endforeach
                        @else
                            <option>NO DATE AVAILABLE</option>
                        @endif

                           
                    </select>
                </div>         
            </div>
        </div>

        

    </div>

</div>

</form>

               
<script src="{{ asset('js/booking.js') }}" defer></script>



@endsection




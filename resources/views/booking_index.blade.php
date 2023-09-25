@extends('layouts.master')


@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Booking</h1>
    <a href="{{ route('export.bookings') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->

<div class="row">

        <!-- Manage Booking Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Booking</h6>
                  
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <a href="{{ route('booking.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New Booking
                            </a>
                        </div>

                         <div class="d-none d-sm-inline col-sm-auto">
                            <a href="{{ route('booking.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                            </a>
                        </div>

                        <div class="col col-lg-3" >
                            <form action ="{{ route('booking.index')}}" method="get">
                                <div class="input-group input-group-sm">
                                    <input type="search" name="search" class="form-control input-sm ">
                                    <span class="input-group-prepend">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-fw fa-search"></i></button>
                                    </span>
                                </div>
                            </form>
                        </div>

                    </div>

                  <br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                                <tr>
                                    <th>#</th>
                                    <th>Book No</th>
                                    <th style="width:25%;">Owner Name</th>
                                    <th>Shipment Details</th>
                                    <th style="width:20%;">Destination</th>
                                    <!-- <th>Pickup & Delivery</th> -->
                                    <!-- <th>Amount</th> -->
                                    <th style="text-align:center;">Status </th>
                                    <th style="text-align:center;">Action</th>
                                </tr>

                                @php ($i=1)
                                @forelse($bookings as $booking)
                                   
                                    <tr>
                                        <td>{{ ($bookings->currentPage() - 1) * $bookings->links()->paginator->perPage() + $loop->iteration  }}</td>
                                        <td>{{ $booking->booking_no  }}</td>
                                        <td>
                                            {{ $booking->customer()->name }} <br>
                                            {{ $booking->customer()->ic }} <br>
                                            {{ $booking->customer()->phone }}
                                        </td>
                                        <td>
                                            {{ $booking->shipment()->name }}<br>
                                            {{ $booking->shipment()->number }}<br>
                                            {{ Carbon\Carbon::parse($booking->shipment()->date)->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $booking->shipment()->port_from }} - {{ $booking->shipment()->port_to }}</td> 
                                        <!-- <td>{{ $booking->amount }}</td> -->

                                        <td style="text-align:center;">
                                        @if($booking->booking_status == 'CANCEL')
                                            <p style="color:red;">{{ $booking->booking_status }}</p>
                                        @elseif($booking->booking_status == 'PENDING')
                                            <p style="color:orange;">{{ $booking->booking_status }}</p>
                                        @elseif($booking->booking_status == 'PAID')
                                            <p style="color:green;">{{ $booking->booking_status }}</p>
                                        @endif
                                        </td>
                                        
                                        <td style="text-align:center;">
                                            @if($booking->booking_status == 'CANCEL')
                                            
                                            @else
                                                <div class="btn-group">
                                                    <form method="POST" action="{{route('booking.destroy', $booking->id)}}">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="booking_status" value="CANCEL">
                                                        @csrf
                                                             <button class=" btn btn-sm btn-danger">
                                                                <i class="fas fa-fw fa-trash"></i>
                                                            </button>
                                                    </form>
                                                    &nbsp;
                                                
                                                    <a href="{{route('booking.edit', $booking->id)}}" class=" btn btn-sm btn-primary">
                                                        <i class="fas fa-fw fa-edit"></i>
                                                    </a>

                                                    &nbsp;

                                                    <!-- <a href="{{route('booking.show', $booking->id)}}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;" class=" btn btn-sm btn-info">
                                                         <i class="fas fa-fw fa-eye"></i>
                                                    </a> -->

                                                    @if($booking->booking_status == 'PENDING')
                                                    <!-- Show dropdown with only Quotation and Invoice options -->
                                                    <div class="dropdown">
                                                        <a href="#"  data-toggle="dropdown" class=" btn btn-sm btn-info dropdown-toggle">
                                                            <i class="fas fa-fw fa-eye"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('booking.show', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">QUOTATION</a>
                                                            <a class="dropdown-item" href="{{ route('booking.showInvoice', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">INVOICE</a>
                                                            <a class="dropdown-item" href="{{ route('booking.showConfirm', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">CONFIRMATION BOOKING</a>
                                                        </div>
                                                    </div>
                                                    @elseif($booking->booking_status == 'PAID')
                                                    <!-- Show dropdown with all options -->
                                                    <div class="dropdown">
                                                        <a href="#"  data-toggle="dropdown" class=" btn btn-sm btn-info dropdown-toggle">
                                                            <i class="fas fa-fw fa-eye"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('booking.show', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">QUOTATION</a>
                                                            <a class="dropdown-item" href="{{ route('booking.showInvoice', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">INVOICE</a>
                                                            <a class="dropdown-item" href="{{ route('booking.showConfirm', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">CONFIRMATION BOOKING</a>
                                                            <a class="dropdown-item" href="{{ route('booking.showReceipt', $booking->id) }}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=800,height=500,toolbar=1,resizable=0'); return false;">RECEIPT</a>
                                                        </div>
                                                    </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>                                      
                                    </tr>
                                 @empty

                                    <p class="text-center">No result found <strong>: {{ request()->query('search')}}</strong></p>

                                @endforelse 
                        </table>  
                </div>
                            

                            {{ $bookings->links() }}
                </div>
            </div>
        </div>

        
</div>



@endsection
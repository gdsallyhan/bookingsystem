@extends('layouts.master')


@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Shipment</h1>
   <!-- <a hr ef="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->

<div class="row">

        <!-- Manage Booking Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Shipment</h6>
                  
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <a href="{{ route('shipment.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New Shipment
                            </a>
                        </div>

                         <div class="d-none d-sm-inline col-sm-auto">
                            <a href="{{ route('shipment.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                            </a>
                        </div>

                        <div class="col col-lg-3" >
                            <form action ="{{ route('shipment.index')}}" method="get">
                                <div class="input-group input-group-sm">
                                    <input type="search" name="search" class="form-control input-sm">
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
                            <th style="text-align:center;">#</th>
                            <th>Date</th>
                            <th>Ship Name</th>
                            <th>Ship No.</th>
                            <th>Port From</th>
                            <th>Port To</th>
                            <th style="text-align:center;width:15%;">Action</th>
                        </tr>

                        @php ($i=1)
                        @forelse($shipments as $shipment)
                        <tr>
                            <td style="text-align:center;">{{ ($shipments->currentPage() - 1) * $shipments->links()->paginator->perPage() + $loop->iteration  }}</td>
                            <td>{{ Carbon\Carbon::parse($shipment->date)->format('d/m/Y') }}</td>
                            <td>{{ $shipment->name }}</td>
                            <td>{{ $shipment->number }}</td>
                            <td>{{ $shipment->port_from }}</td>
                            <td>{{ $shipment->port_to }}</td>

                            <td style="text-align:center;">
                                <div class="btn-group">
                                <form method="POST" action="{{route('shipment.destroy', $shipment->id)}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    @csrf
                                             <button class=" btn btn-sm btn-danger">
                                                <i class="fas fa-fw fa-trash"></i>
                                             </button>
                                </form>
                                            &nbsp;
                                             
                                             <a href="{{route('shipment.edit', $shipment->id)}}" class=" btn btn-sm btn-primary">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>
                                </div>
                            </td>
                        </tr>
                        
                        @empty

                        <p class="text-center">No result found <strong>: {{ request()->query('search')}}</strong></p>

                        @endforelse

                    </table>
                </div>
                            {{ $shipments->links() }}
                </div>
            </div>
        </div>     
</div>



@endsection

               
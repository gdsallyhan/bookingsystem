@extends('layouts.master')


@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Vehicle</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->

<div class="row">

        <!-- Manage Booking Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Vehicle</h6>
                  
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <!-- <a href="{{ route('vehicle.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New Vehicle
                            </a> -->
                        </div>

                         <div class="d-none d-sm-inline col-sm-auto">
                            <a href="{{ route('vehicle.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                            </a>
                        </div>

                        <div class="col col-lg-3" >
                            <form action ="{{ route('vehicle.index')}}" method="get">
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
                            <th>Booking No.</th>
                            <th>Customer Name</th>
                            <th>Type</th>
                            <th>Plate No.</th>
                            <th>Model</th>
                            <th>Personal Effect</th>
                      <!--  <th>Engine No.</th>
                            <th>Chasis No.</th>
                            <th>Color</th>
                            <th>Year</th>
                            <th>Grant Letter</th>
                            <th>Loan Letter</th> -->
                            <th style="text-align:center;width:15%;">Action</th> 
                        </tr>

                        @php ($i=1)
                        @forelse($vehicles as $vehicle)
                        <tr>
                            <td style="text-align:center;">{{ ($vehicles->currentPage() - 1) * $vehicles->links()->paginator->perPage() + $loop->iteration  }}</td>

                            <td>{{ $vehicle->booking_no }}</td>
                            <td>{{ $vehicle->name }}  <br> 
                                {{ $vehicle->phone }}
                            </td>
                            <td>{{ $vehicle->type }}</td>
                            <td>{{ $vehicle->plate_no }}</td>
                            <td>{{ $vehicle->model }}</td>
                            <td>{{ $vehicle->personal_effect }}</td>
                        <!--<td>{{ $vehicle->engine }}</td>
                            <td>{{ $vehicle->chasis }}</td>
                            <td>{{ $vehicle->color }}</td>
                            <td>{{ $vehicle->year }}</td>
                            <td>{{ $vehicle->file_geran }}</td>
                            <td>{{ $vehicle->file_loan }}</td> -->

                            <td style="text-align:center;">

                                <form method="POST" action="{{route('vehicle.destroy', $vehicle->id)}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                @csrf

                                        <div class="btn-group">
                                            <!-- <button class=" btn btn-sm btn-danger">
                                                <i class="icon-trash"> Trash</i>
                                            </button>
 -->                                </form>
                                            &nbsp;

                                            <a href="{{route('vehicle.edit', $vehicle->id)}}" class=" btn btn-sm btn-primary">
                                                <i class="fas fa-fw fa-edit"></i>
                                            </a>

                                            &nbsp;

                                             <a href="{{route('vehicle.show', $vehicle->id)}}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=550,height=500,toolbar=1,resizable=0'); return false;" class=" btn btn-sm btn-info">
                                                <i class="fas fa-fw fa-eye"></i>
                                            </a>


                                        </div>
                                
                            </td>
                        </tr>
                         @empty

                            <p class="text-center">No result found <strong>: {{ request()->query('search')}}</strong></p>

                        @endforelse
                    </table>
                </div>
                        {{ $vehicles->links() }}
                </div>
            </div>
        </div>     
</div>


@endsection
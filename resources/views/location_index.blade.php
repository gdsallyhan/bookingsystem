@extends('layouts.master')


@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Location</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->

<div class="row">

        <!-- Manage Booking Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Location</h6>
                  
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <a href="{{ route('location.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New Location
                            </a>
                        </div>

                         <div class="d-none d-sm-inline col-sm-auto">
                            <a href="{{ route('location.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                            </a>
                        </div>

                        <div class="col col-lg-3" >
                            <form action ="{{ route('location.index')}}" method="get">
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
                            <th>Location Name</th>
                            <th>State</th>
                            <th>Port</th>
                            <th>Price</th>
                            <th>Carrier By</th>
                            <th>Status</th>
                            <th style="text-align:center;">Action</th>
                        </tr>

                        @php ($i=1)
                        @forelse($locations as $location)
                        <tr>
                            <td style="text-align:center;">{{ ($locations->currentPage() - 1) * $locations->links()->paginator->perPage() + $loop->iteration  }}</td>
                            <td>{{ $location->name }}</td>
                            <td>{{ $location->state }}</td>
                            <td>{{ $location->port }}</td>
                            <td>{{ number_format($location->price, 2,"." ,",") }}</td>
                            <td>{{ $location->carry_by }}</td>
                            <td>@if($location->status == '1')
                                ACTIVE
                                @else
                                INACTIVE
                                @endif
                            </td>

                            <td style="text-align:center;"> 
                                <form method="POST" action="{{route('location.destroy', $location->id)}}">
                                       <input type="hidden" name="_method" value="DELETE">
                                    @csrf

                                        <div class="btn-group">
                                             <button class=" btn btn-sm btn-danger">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                </form>
                                        &nbsp;
                                            <a href="{{route('location.edit', $location->id)}}" class=" btn btn-sm btn-primary">
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
                            {{ $locations->links() }}
                </div>
            </div>
        </div>     
</div>





@endsection
@extends('layouts.master')


@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Customer</h1>
   <!-- <a hr ef="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->

<div class="row">

        <!-- Manage Booking Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Customer</h6>
                  
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <a href="{{ route('customer.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New Customer
                            </a>
                        </div>

                         <div class="d-none d-sm-inline col-sm-auto">
                            <a href="{{ route('customer.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                            </a>
                        </div>

                        <div class="col col-lg-3" >
                            <form action ="{{ route('customer.index')}}" method="get">
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
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>ID Number</th>
                            <th style="text-align:center;">ID File</th>
                            <th style="text-align:center;">Action</th>
                        </tr>

                        @php ($i=1)
                        @forelse($customers as $customer) 

                        <tr>
                            <td style="text-align:center;">{{ ($customers->currentPage() - 1) * $customers->links()->paginator->perPage() + $loop->iteration  }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->ic }}</td>
                            <td style="text-align:center;">
                                @if($customer->attachment_ic != '')
                                   <a href="{{route('customer.show', $customer->id)}}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=700,height=500,toolbar=1,resizable=0');return false;" >
                                    <img src="{{ asset('/icon/uploaded.png')}}" width="40" height="40">
                                    </a>
                                @else
                                <img src="{{ asset('/icon/no_uploaded.png')}}" width="40" height="40">
                                 @endif
                            </td>
                            <td style="text-align:center;"> 

                                <div class="btn-group">
                                    <form method="POST" action="{{route('customer.destroy', $customer->id)}}">
                                       <input type="hidden" name="_method" value="DELETE">
                                    @csrf

                                            <button class=" btn btn-sm btn-danger">
                                            <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                    </form>
                                            &nbsp;

                                            <a href="{{route('customer.edit', $customer->id)}}" class=" btn btn-sm btn-primary">
                                            <i class="fas fa-fw fa-edit"></i></a>
                                </div>
                            </td>
                        </tr>

                        @empty

                        <p class="text-center">No result found <strong>: {{ request()->query('search')}}</strong></p>

                        @endforelse
                    </table>
                </div>
                            {{ $customers->links() }}
                </div>
            </div>
        </div>     
</div>


@endsection
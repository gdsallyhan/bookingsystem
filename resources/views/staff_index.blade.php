@extends('layouts.master')


@section('content')


<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Staff</h1>
   <!-- <a hr ef="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->

<div class="row">

        <!-- Manage Booking Table -->
        <div class="col-xl-12 col-lg-12">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Manage Staff</h6>
                  
                </div>
                <!-- Card Body -->
                <div class="card-body">

                    <div class="row">

                        <div class="col">
                            <a href="{{ route('staff.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New Staff
                            </a>
                        </div>

                         <div class="d-none d-sm-inline col-sm-auto">
                            <a href="{{ route('staff.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                            </a>
                        </div>

                        <div class="col col-lg-3" >
                            <form action ="{{ route('staff.index')}}" method="get">
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
                            <th>Staff Name</th>
                            <th>Email</th>
                            <th style="text-align:center;width:10%;">Avatar</th>
                            <th style="text-align:center;width:15%;">Action</th>
                        </tr>

                        @php ($i=1)
                        @forelse($users as $user)
                        <tr>
                            <td style="text-align:center;">{{ ($users->currentPage() - 1) * $users->links()->paginator->perPage() + $loop->iteration  }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td style="text-align:center;">
                                @if($user->avatar != "")
                                <img class="image rounded-circle" src="{{ asset('/'.$user->avatar) }}" style=" width:60px; height: 60px, padding: 10px; margin: 0px; border-radius: 50%;" alt="" >
                                @else
                                <img class="image rounded-circle" src="{{ asset('/icon/default-avatar.png') }}" style=" width:60px; height:60px, padding: 10px; margin: 0px; border-radius: 50%;" alt="" >
                                @endif
                            </td>
                           <td style="text-align:center;">
                                <form method="POST" action="{{route('staff.destroy', $user->id)}}">
                                   <input type="hidden" name="_method" value="DELETE">
                                @csrf

                                        <div class="btn-group">
                                            <button class=" btn btn-sm btn-danger">
                                            <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                </form>
                                        &nbsp;

                                            <a href="{{route('staff.edit', $user->id)}}" class=" btn btn-sm btn-primary">
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
                            {{ $users->links() }}
                </div>
            </div>
        </div>     
</div>





@endsection
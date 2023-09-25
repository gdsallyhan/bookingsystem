@extends('layouts.master')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Payment</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
</div>

<!-- Content Row -->

<div class="row">

    <!-- Manage Payment Table -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Manage Payment</h6>
            </div>
            <!-- Card Body -->
            <div class="card-body">

                <div class="row">

                    <div class="col">
                        <!-- <a href="{{ route('payment.create')}}" class="btn btn-primary btn-sm"> <i class="fas fa-fw fa-plus"></i> New payment
                        </a> -->
                    </div>

                     <div class="d-none d-sm-inline col-sm-auto">
                        <a href="{{ route('payment.index')}}" class="d-none d-sm-inline btn btn-primary btn-sm"><i class="fas fa-fw fa-eraser"></i>
                        </a>
                    </div>

                    <div class="col col-lg-3" >
                        <form action ="{{ route('payment.index')}}" method="get">
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
                            <th>Customer Details</th>
                            <th>Mode</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Ref</th>
                            <th style="text-align:center;">Details</th>
                        </tr>

                        @php ($i=1)
                        @forelse($payments as $payment)
                        <tr>
                            <td style="text-align:center;">{{ ($payments->currentPage() - 1) * $payments->links()->paginator->perPage() + $loop->iteration  }}</td>

                            <td>{{ $payment->booking()->booking_no }}</td>
                            <td>{{ $payment->customer()->name }}  <br>
                                {{ $payment->customer()->phone }}
                            </td>
                            <td>{{ $payment->mode }}</td>
                            <td>RM{{ number_format($payment->amount,2,".",",") }}</td>
                            <td>
                                @if($payment->status == 1)
                                    Success
                                @elseif ($payment->status == 2)
                                    Unsuccessful
                                @elseif($payment->status == 3)
                                    Unsuccessful
                                @endif
                            </td>
                            <td>{{ $payment->ref }}</td>

                            <td style="text-align:center;">
                                <form method="POST" action="{{route('payment.destroy', $payment->id)}}">
                                    <input type="hidden" name="_method" value="DELETE">
                                    @csrf
                                    <div class="btn-group">
                                        <!-- <button class=" btn btn-sm btn-danger">
                                            <i class="icon-trash"> Trash</i>
                                        </button>
                                        -->
                                    </div>
                                </form>
                            
                                &nbsp;
                            
                                @if($payment->status == 1)
                                    <a href="{{route('payment.show', $payment->id)}}" onclick="window.open(this.href, '_blank', 'left=20,top=20,width=550,height=500,toolbar=1,resizable=0'); return false;" class=" btn btn-sm btn-info">
                                        <i class="fas fa-fw fa-file"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                            <p class="text-center">No result found <strong>: {{ request()->query('search')}}</strong></p>
                        @endforelse
                    </table>
                </div>
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layouts.displays')

@section('content')

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="font-weight-bold">Payment Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Booking No.</th>
                        <td>{{ $payment->booking()->booking_no }}</td>
                    </tr>
                    <tr>
                        <th>Customer Name</th>
                        <td>{{ $payment->customer()->name }}</td>
                    </tr>
                    <tr>
                        <th>Mode</th>
                        <td>{{ $payment->mode }}</td>
                    </tr>
                    <tr>
                        <th>Amount</th>
                        <td>RM{{ number_format($payment->amount,2,".",",") }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($payment->status == 1)
                                    Success
                                @elseif ($payment->status == 2)
                                    Unsuccessful
                                @elseif($payment->status == 3)
                                    Unsuccessful
                                @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Reference Number</th>
                        <td>{{ $payment->ref }}</td>
                    </tr>
                    <tr>
                        <th>Payment Date</th>
                        <td>{{ $payment->payment_date }}</td>
                    </tr>
                    <tr>
                        <th>Payment Time</th>
                        <td>{{ $payment->payment_time }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

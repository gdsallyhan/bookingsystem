<?php

namespace App\Exports;
use Illuminate\Support\Collection;
use App\Booking;
use App\ModelVehicle;
use App\Vehicle;
use App\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PaymentExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $booking = Booking::select(
            'bookings.created_at',
            'bookings.booking_no',
            'customers.name as customer name',
            'customers.phone',
            'bookings.booking_date',
            'bookings.booking_status',
            'payments.amount',
            'payments.status',
            'payments.ref',
            'payments.payment_date',
            'payments.payment_time',
            
        )
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->join('payments', 'payments.booking_id', '=', 'bookings.id')
            ->whereNull('bookings.deleted_at')
            ->where('bookings.deleted_at')
            ->get()->toArray();

        return collect($booking);
    }

    public function headings(): array
    {
        // Define the headings for the exported booking data as an array of strings
        return [
            'Created At',
            'Booking No.',
            'Customer Name',
            'Contact No.',
            'Booking Date',
            'Booking Status',
            'Amount',
            'Code Status',
            'Reference',
            'Payment Date',
            'Payment Time',
        ];
    }
}

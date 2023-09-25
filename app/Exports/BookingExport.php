<?php

namespace App\Exports;

use App\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Booking::all();
        // Retrieve and return the booking data as a collection
        return Booking::select(
            'customers.name as customer_name',
            'bookings.booking_no',
            'customers.phone',
            'bookings.booking_date',
            'bookings.booking_status',
            'bookings.amount',
            'bookings.notes',
            'shipments.name as vessel_name',
            'shipments.number as vessel_number',
            'shipments.date as shipping_date',
            'shipments.port_from as pol',
            'shipments.port_to as pod',
            // 'locations.carry_by as carry_by', // Assuming 'carry_by' is in the 'locations' table
            'model_vehicles.model as Model',
            // 'vehicles.type as Type',
            // 'vehicles.model as Model',
            'vehicles.plate_no as Plate No',
            'vehicles.engine as Engine',
            'vehicles.chasis as Chasis',
            'vehicles.color as Color',
            'vehicles.year as Year Manufactured',
            'vehicles.personal_effect as Personal Effect',
            'bookings.created_at'
        )
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->join('shipments', 'shipments.id', '=', 'bookings.shipment_id')
            ->join('locations', 'locations.id', '=', 'bookings.id') // Updated join condition
            ->join('vehicles', 'vehicles.booking_id', '=', 'bookings.id')   // Adjusted join condition
            ->join('model_vehicles', 'model_vehicles.id', '=', 'bookings.id')
            ->whereNull('bookings.deleted_at')
            ->get();
    }

    public function headings(): array
    {
        // Define the headings for the exported booking data as an array of strings
        return [
            'Customer Name',
            'Booking No.',
            'Contact No.',
            'Booking Date',
            'Booking Status',
            'Amount',
            'Remarks',
            'Vessel Name',
            'Vessel Number',
            'Shipping Date',
            'Pol',
            'Pod',
            'Collection',
            'Delivery',
            'Model',
            'Regist No',
            'Engine',
            'Chassis',
            'Color',
            'Year',
            'Personal Effect',
            'Created At',
        ];
    }
}

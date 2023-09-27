<?php

namespace App\Exports;
use Illuminate\Support\Collection;
use App\Booking;
use App\ModelVehicle;
use App\Vehicle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Retrieve and return the booking data as a collection
        $booking = Booking::select(
            'bookings.created_at',
            'bookings.booking_no',
            'customers.name as customer name',
            'customers.phone',
            'bookings.booking_date',
            'bookings.booking_status',
            'bookings.amount',
            'bookings.notes',
            'shipments.name as vessel name',
            'shipments.number as vessel number',
            'shipments.date as shipping date',
            'shipments.port_from as pol',
            'shipments.port_to as pod',
        )
            ->join('customers', 'customers.id', '=', 'bookings.customer_id')
            ->join('shipments', 'shipments.id', '=', 'bookings.shipment_id')
            ->join('locations', 'locations.id', '=', 'bookings.id')
            ->whereNull('bookings.deleted_at')
            ->where('bookings.deleted_at')
            ->get()->toArray();

        $loc_pick = Booking::select('locations.name as collection')
            ->join('locations', 'locations.id', '=', 'bookings.location_id_pickup')
            ->get()->toArray();

        $loc_delivery = Booking::select('locations.name as delivery')
            ->join('locations', 'locations.id', '=', 'bookings.location_id_delivery')
            ->get()->toArray();

        $vehicle = Vehicle::select('model_vehicles.make',
            'model_vehicles.model',
            'model_vehicles.category',
            'model_vehicles.year as year manufactured',
            'vehicles.plate_no as plate no',
            'vehicles.engine',
            'vehicles.chasis',
            'vehicles.color',
            'vehicles.personal_effect')

            ->join('model_vehicles', 'model_vehicles.id', '=', 'vehicles.model_id')
            ->get()->toArray();

            $merge = array_merge($booking,$loc_pick,$loc_delivery,$vehicle);
            
            $flattenedArray = collect($merge)->flatten()->all();
            
        return collect([$flattenedArray]);
    
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
            'Remarks',
            'Vessel Name',
            'Vessel Number',
            'Shipping Date',
            'Pol',
            'Pod',
            'Collection',
            'Delivery',
            'Brand',
            'Model',
            'Body Type',
            'Year',
            'Regist No',
            'Engine',
            'Chassis',
            'Color',
            'Personal Effect',
            
        ];
    }
}

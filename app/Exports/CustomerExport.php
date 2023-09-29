<?php

namespace App\Exports;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class CustomerExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {

        $customer = Customer::select(
            'customers.id',
            'customers.name',
            'customers.phone',
            'customers.email',
            'customers.ic',
            'customers.attachment_ic',
            'customers.created_at',
        )
            ->whereNull('customers.deleted_at')
            ->get()->toArray();

        return collect($customer);
    }

    public function headings(): array
    {
        // Define the headings for the exported booking data as an array of strings
        return [

            'No.',
            'Name',
            'Contact No.',
            'Email',
            'Identification No.',
            'Identification Attachment',
            'Created At',
        ];
    }
}

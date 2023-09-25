<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        foreach(range(1,100)as $index)
        {
            DB::table('bookings')->insert([
            'customer_id' => random_int(1, 9),
            'shipment_id' => random_int(1, 9),
            'location_id_delivery' => random_int(1, 9),
            'location_id_pickup' => random_int(1, 9),
            'package_id' => random_int(1, 9),
            'insurance_id' => random_int(1, 9),
            'booking_no' => random_int(1, 9),
            'booking_date' => Carbon::now()->subMinutes(rand(1, 55)),
            'booking_status' => 'NEW',
            'amount' => random_int(1, 9),
            'user_id' =>random_int(1, 9),
            'notes' => Str::random(10),
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now()

        ]);

        }


        // $faker = Faker::create();
        // foreach(range(1,100)as $index)
        // {
        //     DB::table('customers')->insert([
        //     'name' => Str::random(20),
        //     'phone' => random_int(987654321, 1234567899),
        //     'email' => Str::random(20),
        //     'ic' => Str::random(20),
        //     'attachment_ic' => Str::random(10),
        //     'created_at'=> Carbon::now(),
        //     'updated_at'=> Carbon::now()

        // ]);
            
        // }
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->bigInteger('shipment_id');
            $table->bigInteger('location_id_delivery');
            $table->bigInteger('location_id_pickup');
            $table->bigInteger('package_id');
            $table->bigInteger('insurance_id');
            $table->string('booking_no')->nullable();
            $table->date('booking_date')->nullable();
            $table->string('booking_status')->default('new');
            $table->decimal('amount',15,2)->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->string('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}

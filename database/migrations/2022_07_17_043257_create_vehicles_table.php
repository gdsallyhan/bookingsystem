<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->bigInteger('booking_id');
            $table->string('type')->nullable();
            $table->string('plate_no')->nullable();
            $table->string('model')->nullable();
            $table->string('engine')->nullable();
            $table->string('chasis')->nullable();
            $table->string('color')->nullable();
            $table->string('year')->nullable();
            $table->string('file_geran')->nullable();
            $table->string('file_loan')->nullable();
            $table->string('personal_effect')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingKitchenstyleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('booking_kitchenstyle', function (Blueprint $table) {
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings');
            $table->integer('kitchenstyle_id')->unsigned();
            $table->foreign('kitchenstyle_id')->references('id')->on('kitchenstyles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('booking_kitchenstyle');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("bookingdates", function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date');
            $table->integer('booking_id')->unsigned();
            $table->foreign('booking_id')->references('id')->on('bookings');
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
        Schema::dropIfExists('bookingdates');
    }
}

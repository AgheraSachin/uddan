<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblBookHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_history', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_number');
            $table->string('vehicle_type');
            $table->unsignedBigInteger('parking_lot_id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->string('charge');
            $table->timestamps();
            $table->foreign('parking_lot_id')->references('id')->on('parking_lots');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('book_history');
    }
}

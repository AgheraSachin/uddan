<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblParkingLots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_lots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('max_capacity_two_wheels');
            $table->string('max_capacity_four_wheels');
            $table->string('per_hour_charge_two_wheels');
            $table->string('per_hour_charge_four_wheels');
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
        Schema::dropIfExists('parking_lots');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    use HasFactory;

    public $table = 'parking_lots';

    public $fillable = ['name', 'max_capacity_two_wheels', 'max_capacity_four_wheels', 'per_hour_charge_two_wheels', 'per_hour_charge_four_wheels'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $table = 'book_history';

    public $fillable = ['vehicle_number', 'parking_lot_id', 'from', 'to','vehicle_type','charge'];
}

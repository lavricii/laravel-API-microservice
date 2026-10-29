<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_name',
        'car_plate',
        'insurer_name',
        'price',
    ];
}

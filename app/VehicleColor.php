<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleColor extends Model
{
    protected $table = 'vehicle_colors';

    protected $fillable = [
        'vehicle_id', 'available_colors'
    ];
}

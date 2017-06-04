<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    protected $table = 'vehicle_type';


    protected $fillable = [
        'name', 'description'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{


    protected $table = 'vehicle_model';


    protected $fillable = [
        'name', 'description'
    ];
}

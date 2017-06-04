<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{


    protected $table = 'vehicle';


    protected $fillable = [
        'type_id', 'model_id','production_year','engine_displacement','engine_details','fuel_system'
    ];
}

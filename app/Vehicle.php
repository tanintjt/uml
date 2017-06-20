<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{


    protected $table = 'vehicle';


    protected $fillable = [
       'brand_id', 'type_id', 'model_id','production_year','engine_displacement','engine_details','fuel_system','vehicle_image'
    ];

    public function types(){
        return $this->belongsTo('App\VehicleType','type_id', 'id');
    }

    public function model(){
        return $this->belongsTo('App\VehicleModel','model_id', 'id');
    }

    public function brand(){
        return $this->belongsTo('App\Brand','brand_id', 'id');
    }


}

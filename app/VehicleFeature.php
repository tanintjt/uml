<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleFeature extends Model
{


    protected $table = 'vehicle_features';

    protected $fillable = [
        'vehicle_id', 'features'
    ];


    /*public function vehicle_features(){
        return $this->belongsToMany('App\vehicle_features','vehicle_id', 'id');
    }*/
}

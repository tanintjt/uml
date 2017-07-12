<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleColor extends Model
{
    protected $table = 'vehicle_color';

    protected $fillable = [
        'vehicle_id', 'available_colors'
    ];


    public function vehicle(){
        return $this->belongsToMany('App\vehicle_color','vehicle_id', 'id');
    }
}

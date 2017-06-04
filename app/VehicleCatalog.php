<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleCatalog extends Model
{
    protected $table = 'vehicle_catalog';


    protected $fillable = [
        'vehicle_type', 'vehicle_id','brand_id','vehicle_model','vehicle_image'
    ];
}

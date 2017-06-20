<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{


    protected $table = 'vehicle_model';


    protected $fillable = [
        'name', 'description'
    ];

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }
}

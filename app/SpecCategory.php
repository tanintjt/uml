<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecCategory extends Model
{

    protected $table = 'spec_category';

    protected $fillable = [
        'title', 'status'
    ];

    /*public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {

            return $query->join('vehicle', 'user_vehicles.vehicle_id', '=', 'vehicle.id')
                ->join('vehicle_model', 'vehicle.model_id', '=', 'vehicle_model.id')
                ->join('users', 'user_vehicles.user_id', '=', 'users.id')
                ->where('vehicle.chesis_no', 'LIKE', '%' . trim($name) . '%')
                ->orWhere('vehicle.engine_no', 'LIKE', '%' . trim($name) . '%')
                ->orWhere('vehicle_model.name', 'LIKE', '%' . trim($name) . '%')
                ->orWhere('users.name', 'LIKE', '%' . trim($name) . '%');
        }
    }*/


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('title', 'LIKE', '%' . trim($name) . '%');
        }
    }

    public function spec_details(){
        return $this->hasMany('App\SpecDetails','cat_id', 'id')
            ->select('title','spec_value as value');
    }

    public  function specDetails($query,$name){

        if( $name > 0 ) {

            return $query->join('vehicle', 'spec_details.vehicle_id', '=', 'vehicle.id')->
            where('doc_type_id', $name);
        }
    }
}

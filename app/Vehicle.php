<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{


    protected $table = 'vehicle';


    protected $fillable = [
       'brand_id', 'type_id', 'model_id','production_year','engine_displacement','engine_details','fuel_system','vehicle_image'
    ];

    public function scopeTypeId($query, $typeid)
    {
        if( $typeid > 0 ) {
            return $query->where('vehicle.type_id',$typeid);
        }
    }
    public function scopeModelId($query, $modelid)
    {
        if( $modelid > 0 ) {
            return $query->where('vehicle.model_id', $modelid);
        }
    }

    public function scopeBrandId($query, $brandid)
    {
        if( $brandid > 0 ) {
            return $query->where('vehicle.brand_id', $brandid);
        }
    }

    public function types(){
        return $this->belongsTo('App\VehicleType','type_id', 'id');
    }

    public function model(){
        return $this->belongsTo('App\VehicleModel','model_id', 'id');
    }

    public function brand(){
        return $this->belongsTo('App\Brand','brand_id', 'id');
    }

    public function colors(){
        return $this->hasMany('App\VehicleColor','vehicle_id', 'id')->select('available_colors as image');
    }

    public function features(){
        return $this->hasMany('App\VehicleFeature','vehicle_id', 'id')->select('features as feature_images');
    }

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('users.name', 'LIKE', '%' . trim($name) . '%');
        }
    }



}

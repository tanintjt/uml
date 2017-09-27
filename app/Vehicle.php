<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{


    protected $table = 'vehicle';


    protected $fillable = [
       'brand_id', 'type_id', 'model_id','production_year','engine_displacement','engine_details',
        'fuel_system','vehicle_image','brochure','engine_no','chesis_no','reg_no','color_code'
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
        return $this->hasMany('App\VehicleColor','vehicle_id', 'id')->select('available_colors as img','color_code as hex');
    }


    public function features(){
        return $this->hasMany('App\VehicleFeature','vehicle_id', 'id')->select('features as img','title as sub')->orderBy('id','asc');
    }

    public function scopevehicle($query, $id)
    {
        if( $id > 0 ) {
            return $query->where('id', $id);
        }
    }

    public function spec_details(){
        return $this->hasMany('App\SpecDetails','vehicle_id', 'id')->select('title','spec_value as value');
    }


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('users.name', 'LIKE', '%' . trim($name) . '%');
        }
    }



}

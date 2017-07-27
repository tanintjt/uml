<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    protected $table = 'service_package';


    protected $guarded = array('id');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'details', 'package_rate','package_type_id'
    ];



    public function scopePackageTypeId($query, $typeid)
    {
        if( $typeid > 0 ) {
            return $query->where('service_package.package_type_id', $typeid);
        }
    }

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '') {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }

    public function packages(){
        return $this->belongsTo('App\ServiceRequest','service_package_id','id')->select('name as package_name');
    }

    public function service_package_type(){
        return $this->belongsTo('App\ServicePackageType','package_type_id', 'id');
    }

    public function scopeSP($query, $spid)
    {
        if( $spid > 0 ) {
            return $query->where('service_package.package_type_id',$spid);
        }
    }
}

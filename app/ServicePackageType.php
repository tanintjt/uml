<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServicePackageType extends Model
{
    protected $table = 'service_package_type';


    protected $fillable = [
        'name','status'
    ];

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }

    public function scopeStatus($query, $status)
    {
        if($status > 0) {
            return $query->where('service_package_type.status', '=', $status);
        }
    }

    /**
     * Get the packages.
     */
    public function packages()
    {
        return $this->hasMany('App\ServicePackage','package_type_id')->select('id', 'name');
    }

}

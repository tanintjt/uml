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
        'name', 'details', 'package_rate',
    ];


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('address', 'LIKE', '%' . trim($name) . '%');
        }
    }


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceCenter extends Model
{
    protected $table = 'service_center';


    protected $guarded = array('id');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude', 'longitude', 'phone', 'address','store_image'
    ];



    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('address', 'LIKE', '%' . trim($name) . '%');
        }
    }
}

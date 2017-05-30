<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{


    protected $table = 'service_request';


    protected $guarded = array('id');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_center_id', 'service_package_id','status','request_time'
    ];


    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function service_center()
    {
        return $this->belongsTo('App\ServiceCenter', 'service_center_id');
    }


    public function service_package()
    {
        return $this->belongsTo('App\ServicePackage', 'service_package_id');
    }


    public function scopeUser($query, $userid)
    {
        if($userid > 0) {
            return $query->where('user_id', '=', $userid);
        }
    }

    public function scopeServiceCenter($query, $scid)
    {
        if($scid > 0) {
            return $query->where('service_center_id', '=', $scid);
        }
    }

    public function scopeServicePackage($query, $spid)
    {
        if($spid > 0) {
            return $query->where('service_package_id', '=', $spid);
        }
    }


}

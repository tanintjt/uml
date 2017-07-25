<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVehicle extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'user_vehicles';

    /**
     * With fields are guarded from mass-assignment
     * by default.
     *
     * @var array
     */
    protected $guarded = array('id');




    public function scopeUserId($query, $userid)
    {
        if( $userid > 0 ) {
            return $query->where('user_vehicles.user_id', $userid);
        }
    }

    /*public function scopeModelId($query, $modelid)
    {
        if( $modelid > 0 ) {
            return $query->where('vehicle.model_id', $modelid);
        }
    }*/

    public function users(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function vehicles(){
        return $this->belongsTo('App\Vehicle','vehicle_id', 'id');
    }







}

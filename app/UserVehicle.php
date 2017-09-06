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

    public function scopeSearch($query, $name)
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
    }
    public function users(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function vehicles(){
        return $this->belongsTo('App\Vehicle','vehicle_id', 'id');
    }







}

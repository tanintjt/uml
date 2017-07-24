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


    public function users(){
        return $this->belongsTo('App\User','user_id', 'id');
    }

    public function vehicles(){
        return $this->belongsTo('App\Vehicle','vehicle_id', 'id');
    }





}

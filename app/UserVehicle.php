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








}

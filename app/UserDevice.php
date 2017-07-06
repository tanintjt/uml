<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{


    protected $table = 'users_devices';

    protected $fillable = [
        'user_id', 'device_id'
    ];
}

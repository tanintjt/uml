<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NotificationHistory extends Model
{

    protected $table = 'notification_history';

    protected $guarded = array('id');

    protected $fillable = [
        'user_id','message'
    ];


}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedBack extends Model
{

    protected $table = 'feedback';


    protected $fillable = [
        'user_id','subject','feedback_details'
    ];

    public function users()
    {
        return $this->belongsTo('App\User', 'user_id');

    }

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('feedback.subject', 'LIKE', '%' . trim($name) . '%');
        }
    }
}

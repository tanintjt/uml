<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsEvents extends Model
{

    protected $table = 'news_events';


    protected $fillable = [
        'title','details','file'
    ];

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('title', 'LIKE', '%' . trim($name) . '%');
        }
    }

}

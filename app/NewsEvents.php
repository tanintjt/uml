<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsEvents extends Model
{

    protected $table = 'news_events';


    protected $fillable = [
        'title','details','file'
    ];
}

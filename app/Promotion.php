<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';
   
   
    protected $fillable = [
        'file','title','start_date','end_date'
    ];


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('title', 'LIKE', '%' . trim($name) . '%');
        }
    }

}


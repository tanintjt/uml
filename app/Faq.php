<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faq';


    protected $fillable = [
        'file','title'
    ];


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('title', 'LIKE', '%' . trim($name) . '%');
        }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';


    protected $fillable = [
        'question','answer','status'
    ];


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('title', 'LIKE', '%' . trim($name) . '%');
        }
    }
}

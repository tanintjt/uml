<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{


    protected $table = 'brochure';


    protected $fillable = [
        'file','title'
    ];

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }
}

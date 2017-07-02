<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SparePartsCategory extends Model
{


    protected $table = 'spare_parts_category';


    protected $fillable = [
        'name'
    ];

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }


}

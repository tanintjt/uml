<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    
    protected $table = 'brands';
   
   
     protected $fillable = [
        'parent_id', 'name', 'status',
    ];
     
}

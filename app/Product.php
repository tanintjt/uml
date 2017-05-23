<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
   
   
    protected $fillable = [
        'cat_id', 'brand_id','name', 'information','description','image','status'
    ];
}

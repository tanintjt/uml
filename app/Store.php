<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $table = 'stores';
   
   
    protected $fillable = [
        'name', 'lat', 'lng','address','help_line','image','status'
    ];
       
}

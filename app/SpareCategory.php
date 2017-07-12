<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpareCategory extends Model
{


    protected $table = 'spare_category';


    protected $fillable = [
        'sp_cat_id','sp_id','file'
    ];
}

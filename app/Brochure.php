<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brochure extends Model
{


    protected $table = 'brochure';


    protected $fillable = [
        'file'
    ];
}

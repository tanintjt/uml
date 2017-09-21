<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecDetails extends Model
{

    protected $table = 'spec_details';

    protected $fillable = [
        'vehicle_id', 'cat_id','title','spec_value'
    ];



    public function vehicles(){
        return $this->belongsTo('App\Vehicle','vehicle_id', 'id');
    }

    public function spec_category(){
        return $this->belongsTo('App\SpecCategory','cat_id', 'id');
    }

    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query
//                ->join('spec_category', 'spec_details.cat_id', '=', 'spec_category.id')
//                ->where('spec_category.title', 'LIKE', '%' . trim($name) . '%')
                ->orWhere('spec_details.title', 'LIKE', '%' . trim($name) . '%')
                ->orWhere('spec_details.spec_value', 'LIKE', '%' . trim($name) . '%');
        }
    }




}

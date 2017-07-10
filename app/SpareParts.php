<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpareParts extends Model
{


    protected $table = 'spare_parts';


    protected $fillable = [
        'name','part_id','rate','sp_cat_id'
    ];

    public function scopeSP($query, $spid)
    {
        if( $spid > 0 ) {
            return $query->where('spare_parts.sp_cat_id',$spid);
        }
    }


    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }

    public function sp_cat(){
        return $this->belongsTo('App\SparePartsCategory','sp_cat_id', 'id');
    }
}

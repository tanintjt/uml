<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EDocument extends Model
{

    protected $table = 'e_documents';


    protected $fillable = [
        'doc_type_id','issue_date','expiry_date','file'
    ];

    public function scopeEDoc($query, $type)
    {
        if( trim($type) != '' ) {
            return $query->where('e_doc_type.name', 'LIKE', '%' . trim($type) . '%');
        }

    }


    public function doc_type(){
        return $this->belongsTo('App\EDocType','doc_type_id', 'id');
    }


    public function scopeSearch($query, $name)

    {
        if( trim($name) != '' ) {
            return $query->where('users.name', 'LIKE', '%' . trim($name) . '%');
        }
    }

    public function type(){
        return $this->belongsTo('App\EDocType','doc_type_id', 'id')->select('name as type');
    }

}

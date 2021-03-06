<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EDocument extends Model
{

    protected $table = 'e_documents';


    protected $fillable = [
        'doc_type_id','issue_date','expiry_date','file','user_id'
    ];

    public function scopeEDoc($query, $type)
    {
        if( $type > 0 ) {
            return $query->where('doc_type_id', $type);
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
        return $this->belongsTo('App\EDocType','doc_type_id','id')->select('name');
    }


}

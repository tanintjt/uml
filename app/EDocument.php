<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EDocument extends Model
{

    protected $table = 'e_documents';


    protected $fillable = [
        'doc_type_id','issue_date','expiry_date','file'
    ];

    public function scopeEDoc($query, $typeid)
    {
        if( $typeid > 0 ) {
            return $query->where('e_documents.doc_type_id',$typeid);
        }
    }


    public function doc_type(){
        return $this->belongsTo('App\EDocType','doc_type_id', 'id');
    }
}

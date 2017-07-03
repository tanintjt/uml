<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EDocument extends Model
{

    protected $table = 'e_documents';


    protected $fillable = [
        'doc_type_id','issue_date','expiry_date','file'
    ];

    public function doc_type(){
        return $this->belongsTo('App\EDocType','doc_type_id', 'id');
    }
}

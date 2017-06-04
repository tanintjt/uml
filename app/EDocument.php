<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EDocument extends Model
{

    protected $table = 'e_documents';


    protected $fillable = [
        'doc_type_id','issue_date','expiry_date','file'
    ];
}

<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
class EDocType extends Model
{


    protected $table = 'e_doc_type';


    protected $fillable = [
        'name'
    ];



    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }
}
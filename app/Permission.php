<?php

namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * With fields are guarded from mass-assignment
     * by default.
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'display_name', 'description', 'status',
    ];

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $name)
    {
        if( trim($name) != '' ) {
            return $query->where('name', 'LIKE', '%' . trim($name) . '%');
        }
    }

    /**
     * Scope a query to only include users of a given type.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeStatus($query, $status)
    {
        if($status > 0) {
            return $query->where('status', '=', $status);
        }
    }
}

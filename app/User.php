<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;


class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

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
        'name', 'email', 'password', 'provider', 'provider_id', 'status','remember_token','api_token','device_id','image','parent_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','api_token'
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
            return $query->where('users.name', 'LIKE', '%' . trim($name) . '%');
        }
    }

    public function scopeStatus($query, $status)
    {
        if($status > 0) {
            return $query->where('users.status', '=', $status);
        }
    }


    public function scopeRoleId($query, $roleid)
    {
        if($roleid > 0) {
            return $query->where('role_user.role_id', $roleid);
        }
    }

    public function scopeRole($query)
    {
        $query->leftjoin('role_user','role_user.user_id', '=', 'users.id');
    }

    public function roles(){
        return $this->belongsToMany('App\Role','role_user', 'user_id');
    }



}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    // use SoftDeletes;
    use Notifiable;

    public $timestamps      = false;
    protected $table        = 'to_users';
    protected $primaryKey   = 'u_id';
    protected $fillable     = ['u_username', 'u_password', 'u_suffix', 'u_fname', 'u_mname', 'u_lname', 'u_position', 'u_division', 'u_signature', 
    'u_gender', 'u_image', 'rg_id', 'r_id', 'desktop_time_in', 'is_active', 'remember_token', 'created_at', 'updated_at'];
    protected $dates        = [ 'created_at', 'updated_at' ];

    public function getAuthPassword()
    {
    	return $this->u_password;
    }

    public function setUpasswordAttribute($value)
    {
    	$this->attributes['u_password'] 	= Hash::make($value);
    }

    public function setUfnameAttribute($value)
    {
    	$this->attributes['u_fname'] 		= ucwords($value);
    }

    public function setUmnameAttribute($value)
    {
        $this->attributes['u_mname']        = ucwords($value);
    }

    public function setUlnameAttribute($value)
    {
    	$this->attributes['u_lname'] 		= ucwords($value);
    }

}

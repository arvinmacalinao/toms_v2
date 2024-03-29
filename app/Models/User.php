<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    public $timestamps      = false;
    protected $table        = 'to_users';
    protected $primaryKey   = 'u_id';
    protected $fillable     = ['u_username', 'u_password', 'u_suffix', 'u_fname', 'u_mname', 'u_lname', 'u_position', 'u_division', 'u_signature', 'u_gender', 'u_image', 'rg_id', 'r_id', 'desktop_time_in', 'is_active', 'remember_token', 'encoded_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $dates        = [ 'created_at', 'updated_at', 'deleted_at' ];

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

    public function region()
    {
        return $this->belongsTo('App\Models\Region', 'rg_id', 'rg_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role', 'r_id', 'r_id');
    }

    public function signature()
    {
        if(\Storage::disk('uploads')->exists('signature/'.$this->u_signature)) {
            return asset('storage/uploads/signature/'.$this->u_signature);
        }
    }

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('u_fname', 'LIKE', "%$search%")->orWhere('u_mname', 'LIKE', "%$search%")->orWhere('u_lname', 'LIKE', "%$search%");
		});
    }    
}

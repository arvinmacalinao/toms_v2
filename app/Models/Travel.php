<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Travel extends Model
{
    use SoftDeletes;
    
    protected $table 		= 'to_travels';
    protected $primaryKey 	= 't_id';
    protected $dates 		= ['t_start_date', 't_end_date'];
    protected $fillable 	= ['t_start_date', 't_end_date', 't_purpose', 't_destination', 't_time', 't_remarks', 't_others', 'u_id', 'rg_id', 'm_id', 'is_verified', 'is_rd', 't_rd', 't_sec', 't_usec', 'u_oic', 'oic_designation', 'is_active', 'is_read', 't_file', 't_so', 't_certificate'];

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('t_purpose', 'LIKE', "%$search%");
		});
    }
    
    
    public function passengers()
    {
    	return $this->belongsToMany('App\Models\User', 'to_travel_passengers', 't_id', 'u_id')->withPivot('is_read')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Comment', 't_id', 't_id');
    }
    
    public function documents()
    {
        return $this->belongsToMany('App\Models\Document', 'to_travel_documents', 't_id', 'td_path')->withTimestamps();
    }

    public function files()
    {
        return $this->hasMany('App\Models\Document', 't_id', 't_id');
    }

    public function unread_verifier()
    {
        return $this->hasMany('App\Models\Comment', 't_id', 't_id')->where('u_id', '!=', \Auth::user()->u_id)->where('verified', '=', '0');
    }

    public function unread_usec()
    {
        return $this->hasMany('App\Models\Comment', 't_id', 't_id')->where('u_id', '!=', \Auth::user()->u_id)->where('usec', '=', '0');
    }

    public function unread_sec()
    {
        return $this->hasMany('App\Models\Comment', 't_id', 't_id')->where('u_id', '!=', \Auth::user()->u_id)->where('sec', '=', '0');
    }

    public function unread_rd()
    {
        return $this->hasMany('App\Models\Comment', 't_id', 't_id')->where('u_id', '!=', \Auth::user()->u_id)->where('rd', '=', '0');
    }

    public function unread()
    {
        return $this->belongsToMany('App\Models\User', 'to_travel_comments', 't_id', 'u_id')->where('to_travel_comments.u_id', '!=', \Auth::user()->u_id)->where('is_read', '=', '0')->withTimestamps();
    }

    public function expenses()
    {
        return $this->belongsToMany('App\Models\Expense', 'to_travel_funds_expenses', 't_id', 'e_id')->withPivot('f_id', 'tfe_others')->withTimestamps();
    }

    public function region()
    {
        return $this->hasOne('App\Models\Region', 'rg_id', 'rg_id');
    }

    public function users()
    {
    	return $this->hasMany('App\Models\User', 'u_id', 'u_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User', 'u_id', 'u_id');
    }
    
    public function mode()
    {
        return $this->hasOne('App\Models\Mode', 'm_id', 'm_id');
    }
}

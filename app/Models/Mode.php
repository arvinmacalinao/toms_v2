<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mode extends Model
{
    use SoftDeletes;
    protected $table        =   'to_modes';
    protected $primaryKey   =   'm_id';
    protected $fillable     =   [ 'm_name', 'is_active', 'encoded_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $dates        =   ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('m_name', 'LIKE', "%$search%");
		});
    }  
}


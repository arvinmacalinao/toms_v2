<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{

    use SoftDeletes;

    public $timestamps      = false;
    protected $table = 'to_roles';
    protected $primaryKey = 'r_id';
    protected $fillable     = ['r_name', 'encoded_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $dates        = [ 'created_at', 'updated_at', 'deleted_at' ];


    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('r_name', 'LIKE', "%$search%");
		});
    }  
}

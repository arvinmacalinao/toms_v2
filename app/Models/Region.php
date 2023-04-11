<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{   
    use SoftDeletes;

    public $timestamps      = false;
    protected $table = 'to_regions';
    protected $primaryKey = 'rg_id';
    protected $fillable     = ['rg_name', 'rg_short', 'encoded_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $dates        = [ 'created_at', 'updated_at', 'deleted_at' ];

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('rg_name', 'LIKE', "%$search%")->orWhere('rg_short', 'LIKE', "%$search%");
		});
    }  
}



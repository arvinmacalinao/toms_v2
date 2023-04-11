<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use SoftDeletes;

    protected $table        =   'to_settings';
    protected $primaryKey   =   's_id';
    protected $fillable     =   [ 'rg_id', 's_region_name', 's_region_address', 'encoded_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at' ];
    protected $dates        =   [ 'created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('s_region_name', 'LIKE', "%$search%")->orwhere('s_region_address', 'LIKE', "%$search%");
		});
    }


}

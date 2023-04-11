<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $table        = 'to_expenses';
    protected $primaryKey   = 'e_id';
    protected $fillable     = ['e_id', 'e_name', 'e_order', 'encoded_by', 'created_at', 'updated_by', 'updated_at', 'deleted_by', 'deleted_at'];
    protected $dates        = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch($query, $search) {
        return $query->where(function($query) use($search) {
            if(strlen($search) == 0) return $query;
			$query->where('e_name', 'LIKE', "%$search%");
		});
    }  
}

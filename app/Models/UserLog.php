<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table        = 'to_user_logs';
    protected $primaryKey   = 'ul_id';
    protected $fillable     = [ 'ul_date', 'ul_page_title', 'u_id', 'ul_url', 'r_id', 'ul_agent', 'ul_ip', 'ul_method', 'rg_id', 'synched', 'sync_date' ];
    protected $dates        = [ 'sync_date', 'created_at', 'updated_at', 'deleted_at' ];
}


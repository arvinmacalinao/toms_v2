<?php

namespace App\Http\Controllers;

use Request;
use Carbon\Carbon;
// use Illuminate\Http\Request;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class RecordLogsController extends Controller
{
    public function recordLog() {
        if(Auth::check()) {
            $log_uid    = Request::user()->u_id;
            $log_ugid   = Auth::user()->r_id;
            $log_reg    = Auth::user()->rg_id;
        } else {
            $log_uid    = NULL;
            $log_ugid   = NULL;
            $log_reg    = NULL;
        }

        UserLog::create([
            'ul_date'       => Carbon::now(),
            'ul_page_title' => '',
            'u_id'          => $log_uid,
            'ul_url'        => Request::url(),
            'r_id'          => $log_ugid,
            'ul_agent'      => Request::header('User-Agent'),
            'ul_ip'         => Request::ip(),
            'ul_method'     => Request::getMethod(),
            'rg_id'         => $log_reg,
            'created_at'    => Carbon::now()

            // 'ul_date'       => Carbon::now(),
            // 'ul_page_title' => $request->get('page'),
            // 'u_id'          => $log_uid,
            // 'ul_url'        => $request->url(),
            // 'r_id'         => $log_ugid,
            // 'ul_agent'      => $request->header('User-Agent'),
            // 'ul_ip'         => $request->ip(),
            // 'ul_method'     => $request->getMethod(),
            // 'rg_id'     => $log_reg,
            // 'created_at'    => Carbon::now()
        ]);
    }
}

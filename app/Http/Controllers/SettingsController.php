<?php

namespace App\Http\Controllers;

use View;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Region Settings' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {  
            if(!Auth::user()) {
                abort(404);
            }

            app('App\Http\Controllers\RecordLogsController')->recordLog();
            
            return $next($request);
        });
	}

    public function index(Request $request)
    {   
        $msg        = $request->session()->pull('session_msg', '');
        $search     = $request->get('qsearch') == NULL ? '' : $request->get('qsearch');

        $rows       = Setting::search($search)->paginate(20);

        return view('settings.index', compact('rows', 'msg', 'search'));
    }

    public function new(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $id         = 0;
        $setting       = new Setting;

        return view('settings.form', compact('msg', 'id', 'setting'));
    }

    public function store(FundValidation $request, $id)
    {   
        $input = $request->validated();

        if($id == 0)
        {   
            $request->request->add(['encoded_by' => Auth::id(), 'created_at' => Carbon::now()]);
            $fund     =   Fund::create($request->all());
        }
        else
        {   
            $fund   = Fund::where('f_id', $id)->first();
            if(!$fund) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('fund.index'));
            } else {
                $request->request->add(['updated_by' => Auth::id(), 'updated_at' => Carbon::now()]);            
                $fund->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record Updated');
        return redirect(route('funds.index'));
    }

    public function edit($id)
    {
        $fund     =   Fund::FindorFail($id);

        return view('funds.form', compact('fund', 'id'));
    }

    public function delete(Request $request ,$id)
    {
        $fund = Fund::where('f_id', $id)->first();
        if(!$fund) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('funds.index'));
        } else {
            $fund->delete();
            $fund->update(['deleted_by' => Auth::id()]);
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('funds.index'));
        }
    }
}

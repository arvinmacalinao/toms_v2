<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Mode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ModeValidation;

class VehicleModesController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Vehicle Modes' ];
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
        $msg        =   $request->session()->pull('session_msg', '');
        $search     =   $request->get('qsearch') == NULL ? '' : $request->get('qsearch');

        $rows       =   Mode::search($search)->paginate(20);

        return view('vehicle_modes.index', compact('rows', 'msg', 'search'));
    }

    public function new(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $id         = 0;
        $mode       = new Mode;

        return view('vehicle_modes.form', compact('msg', 'id', 'mode'));
    }

    public function store(ModeValidation $request, $id)
    {   
        $input = $request->validated();

        if($id == 0)
        {   
            $request->request->add(['encoded_by' => Auth::id(), 'created_at' => Carbon::now()]);
            $mode     =   Mode::create($request->all());
        }
        else
        {   
            $mode   = Mode::where('m_id', $id)->first();
            if(!$mode) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('modes.index'));
            } else {
                $request->request->add(['updated_by' => Auth::id(), 'updated_at' => Carbon::now()]);            
                $mode->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record Updated');
        return redirect(route('modes.index'));
    }

    public function edit($id)
    {
        $mode     =   Mode::FindorFail($id);

        return view('vehicle_modes.form', compact('mode', 'id'));
    }

    public function delete(Request $request ,$id)
    {
        $mode = Mode::where('m_id', $id)->first();
        if(!$mode) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('modes.index'));
        } else {
            $mode->delete();
            $mode->update(['deleted_by' => Auth::id()]);
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('modes.index'));
        }
    }
}

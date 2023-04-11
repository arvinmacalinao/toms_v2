<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RoleValidation;

class RolesController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Roles' ];
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

        $rows      =   Role::search($search)->paginate(20);
        return view('roles.index', compact('rows', 'msg', 'search'));
    }

    public function new(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $id         = 0;
        $role       = new Role;

        return view('roles.form', compact('msg', 'id', 'role'));
    }

    public function store(RoleValidation $request, $id)
    {   
        $input = $request->validated();

        if($id == 0)
        {   
            $request->request->add(['encoded_by' => Auth::id(), 'created_at' => Carbon::now()]);
            $role     =   Role::create($request->all());
        }
        else
        {   
            $role   = Role::where('r_id', $id)->first();
            if(!$role) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('roles.index'));
            } else {
                $request->request->add(['updated_by' => Auth::id(), 'updated_at' => Carbon::now()]);            
                $role->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record Updated');
        return redirect(route('roles.index'));
    }

    public function edit($id)
    {
        $role     =   Role::FindorFail($id);

        return view('roles.form', compact('role', 'id'));
    }

    public function delete(Request $request ,$id)
    {
        $role = Role::where('r_id', $id)->first();
        if(!$role) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('roles.index'));
        } else {
            $role->delete();
            $role->update(['deleted_by' => Auth::id()]);
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('roles.index'));
        }
    }
}

<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserValidation;

class AccountsController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Accounts' ];
		View::share('data', $data);

        $this->middleware(function ($request, $next) {  
            if(!Auth::user()) {
                abort(404);
            }

            // app('App\Http\Controllers\RecordLogController')->recordLog();
            
            return $next($request);
        });
	}

    public function index(Request $request)
    {   
        $msg        = $request->session()->pull('session_msg', '');
        $search     = $request->get('qsearch') == NULL ? '' : $request->get('qsearch');

        $rows = User::search($search)->paginate(20);

        return view('accounts.index', compact('rows', 'msg', 'search'));
    }

    public function new(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $id         = 0;
        $user    = new User;

        $regions    = Region::get();
        $roles      = Role::orderby('r_name', 'asc')->get();

        return view('accounts.form', compact('msg', 'id', 'user', 'regions', 'roles'));
    }

    public function store(UserValidation $request, $id)
    {   
        $get_div_name = $request->request->get('r_id');

        $now            = date('Ymdhis');     
        if ($request->hasFile('u_signature')) {
            $attachment     = $request->file('u_signature');
            $extension      = $attachment->getClientOriginalExtension();
            $orig_name      = $attachment->getClientOriginalName();
            $filename       = explode('.',$orig_name)[0];
            $u_sig         = $now.'_'.$orig_name;

            $attachment->storeAs('public/uploads/signature/', $u_sig);            
        } else {
            $u_sig         = NULL;
        }

        $input      = $request->validated();
        if($id == 0) {
            $request->request->add(['created_at' => Carbon::now()]);
            $request->request->add(['u_division' => Role::where('r_id', $get_div_name)->value('r_name')]);
            $user   = User::create($request->except(['u_signature']));
            $user->update(['u_signature' => $u_sig,]);
        } else {
            $user   = User::where('u_id', $id)->first();
            if(!$user) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('accounts.index'));
            } else {
                $request->request->add(['updated_at' => Carbon::now()]);            
                $user->update($request->except(['u_signature']));

                if($request->hasFile('u_signature')){
                    $user->update(['u_signature' => $u_sig]);
                }
            }
        }

        $request->session()->put('session_msg', 'Record updated.');
        return redirect(route('accounts.index'));
    }

    public function edit($id)
    {
        $user =  User::FindorFail($id);

        $regions    = Region::get();
        $roles      = Role::orderby('r_name', 'asc')->get();

        return view('accounts.form', compact('id', 'user', 'regions', 'roles'));
    }

    public function reset(Request $request, $id)
    {
        $user               = User::find($id);
        $user->u_password   = 'd0st!nfo$ys';
        $user->update();
        
        $request->session()->put('session_msg', 'Password successfully updated.');
        return redirect(route('accounts.index'));
    }
}

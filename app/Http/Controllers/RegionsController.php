<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegionValidation;

class RegionsController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Regions' ];
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

        $rows       = Region::search($search)->paginate(20);

        return view('region.index', compact('rows', 'msg', 'search'));
    }

    public function new(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $id         = 0;
        $region       = new Region;

        return view('region.form', compact('msg', 'id', 'region'));
    }

    public function store(RegionValidation $request, $id)
    {   
        $input = $request->validated();

        if($id == 0)
        {   
            $request->request->add(['created_at' => Carbon::now()]);
            $region     =   Region::create($request->all());
        }
        else
        {   
            $region   = Region::where('rg_id', $id)->first();
            if(!$region) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('region.index'));
            } else {
                $request->request->add(['updated_at' => Carbon::now()]);            
                $region->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record Updated');
        return redirect(route('region.index'));
    }

    public function edit($id)
    {
        $region     =   Region::FindorFail($id);

        return view('region.form', compact('region', 'id'));
    }

    public function delete(Request $request ,$id)
    {
        $region = Region::where('rg_id', $id)->first();
        if(!$region) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('region.index'));
        } else {
            $region->delete();
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('region.index'));
        }
    }
}

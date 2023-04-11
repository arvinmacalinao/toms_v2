<?php

namespace App\Http\Controllers;

use View;
use Carbon\Carbon;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ExpenseValidation;

class ExpensesController extends Controller
{
    public function __construct() 
    {
		$data = [ 'page' => 'Expenses' ];
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

        $rows       = Expense::search($search)->paginate(20);

        return view('expenses.index', compact('rows', 'msg', 'search'));
    }

    public function new(Request $request)
    {
        $msg        = $request->session()->pull('session_msg', '');
        $id         = 0;
        $expense       = new Expense;

        return view('expenses.form', compact('msg', 'id', 'expense'));
    }

    public function store(ExpenseValidation $request, $id)
    {   
        $input = $request->validated();

        if($id == 0)
        {   
            $request->request->add(['encoded_by' => Auth::id(), 'created_at' => Carbon::now()]);

            $expense     =   Expense::create($request->all());
        }
        else
        {   
            $expense   = Expense::where('e_id', $id)->first();
            if(!$expense) {
                $request->session()->put('session_msg', 'Record not found!');
                return redirect(route('expenses.index'));
            } else {
                $request->request->add(['updated_by' => Auth::id(), 'updated_at' => Carbon::now()]);            
                $expense->update($request->all());
            }
        }

        $request->session()->put('session_msg', 'Record Updated');
        return redirect(route('expenses.index'));
    }

    public function edit($id)
    {
        $expense     =   Expense::FindorFail($id);

        return view('expenses.form', compact('expense', 'id'));
    }

    public function delete(Request $request ,$id)
    {
        $expense = Expense::where('e_id', $id)->first();
        if(!$expense) {
            $request->session()->put('session_msg', 'Record not found!');
            return redirect(route('expenses.index'));
        } else {
            $expense->delete();
            $expense->update(['deleted_by' => Auth::id()]);
            $request->session()->put('session_msg', 'Record deleted!');
            return redirect(route('expenses.index'));
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
        $data = [ 'page' => 'Log in' ];
		View::share('data', $data);
    }

    public function loginform(Request $request) {
        $msg = $request->session()->pull('session_msg', '');

        // cache requested protected url before login
        $return_url = url()->previous(); 
        if($return_url != route('users.loginform')) {
            $request->session()->put('return_url', $return_url);
        }

        return view('login.login', compact('msg'));
    }

    public function login(Request $request) {

        // check if there was a cached protected url
        $return = $request->session()->get('return_url', url($this->redirectTo));

        $credentials = array(
            'u_username'=> $request->input('username'),
            'password'  => $request->input('password'),
            'is_active' => 1
        );

        if(Auth::attempt($credentials)) {
            return redirect()->route('dashboard.dashboard');
        }

        $credentials = array(
            'u_username'   => $request->input('username'),
            'password'  => $request->input('password'),
            'is_active' => 1
        );

        if(Auth::attempt($credentials)) {
            return redirect($return);
        }

        session(['session_msg' => 'Invalid Username or Password.']);
        return redirect(route('users.loginform'))->withInput($request->input());
    }

    public function logout() {
        Auth::logout();
        session(['session_msg' => 'You have been signed-out.']);
        return redirect(route('users.loginform'));
    }
}

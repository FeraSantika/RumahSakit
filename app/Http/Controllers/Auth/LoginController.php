<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Models\DataUser;
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
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'User_name' => 'required',
            'User_password' => 'required',
        ]);

        $credentials['User_name'] = $credentials['User_name'];
        $credentials['password'] = $credentials['User_password'];
        if (Auth::attempt($credentials)) {
            // return redirect()->route('admin.home');
            $user = Auth::user();
            if ($user->role->Role_name === 'Admin') {
                return redirect()->route('admin.home');
            } elseif ($user->role->Role_name === 'Dokter') {
                return redirect()->route('dokter.home');
            } elseif ($user->role->Role_name === 'Apoteker') {
                return redirect()->route('apoteker.home');
            } elseif ($user->role->Role_name === 'Kasir') {
                return redirect()->route('kasir.home');
            } elseif ($user->role->Role_name === 'Resepsionis') {
                return redirect()->route('resepsionis.home');
            } elseif ($user->role->Role_name === 'Analis Lab') {
                return redirect()->route('analis-lab.home');
            }
        }

        return back()->withErrors([
            'username' => 'Invalid credentials',
        ]);
    }
}

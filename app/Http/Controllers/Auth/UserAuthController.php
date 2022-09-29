<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('admin.pages.auth.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        if (Auth::guard('user')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('/');
        } else {
            return redirect()->intended('login')->with('incorrect', 'Akun tidak ditemukan, periksa kembali username/password Anda');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('user')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('login');
    }
}

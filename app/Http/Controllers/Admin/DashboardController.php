<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function userAuth()
    {
        $user = Auth::guard('user')->user();

        return $user;
    }

    public function index()
    {
        $user = $this->userAuth();
        $data = 12345;
        return view('admin.pages.dashboard.index', compact('data', 'user'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AdminDashBoardController extends Controller
{
    public function index(Request $request)
    {
        $DataBag = array();
        $DataBag['activeSideBarMenu'] = "Dashboard"; 
        return view('admin.dashboard', $DataBag);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.auth.login');
    }
}

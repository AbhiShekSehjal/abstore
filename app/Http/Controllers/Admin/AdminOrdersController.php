<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminOrdersController extends Controller
{
    public function index(){
        if (Auth::check()) {
            return view('admin.orders');
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }
}

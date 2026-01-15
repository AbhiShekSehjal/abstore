<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('admin.profile');
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }
}
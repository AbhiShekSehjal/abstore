<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $settings = Setting::first();
            return view('about', compact('settings'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}

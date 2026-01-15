<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $settings = Setting::first();

            return view('profile', compact('settings'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}

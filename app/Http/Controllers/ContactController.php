<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\admin\Setting;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $settings = Setting::first();

            return view('contact', compact('settings'));
        } else {
            return redirect()->route('LoginPage');
        }
    }
}
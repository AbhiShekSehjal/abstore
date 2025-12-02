<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('contact');
        } else {
            return redirect()->route('LoginPage');
        }
    }
}
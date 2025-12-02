<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function index()
    {
        if(Auth::check()){
        return view('about');
        }else{
            return redirect()->route('LoginPage');
        }
    }
}
<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminProductsController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return view('admin.products');
        } else {
            return redirect()->route('AdminLoginPage');
        }
    }
}
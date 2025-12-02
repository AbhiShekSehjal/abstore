<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function registerPage()
    {
        return view('admin.auth.register');
    }

    public function loginPage()
    {
        return view('admin.auth.login');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'adminName'     => 'required',
            'adminEmail'    => 'required|email|unique:users,email',
            'adminPassword' => 'required|confirmed',
        ]);

        $role = $request->input('role') ?? 'admin';

        $admin = User::create([
            'name'     => $data['adminName'],
            'email'    => $data['adminEmail'],
            'password' => bcrypt($data['adminPassword']),
            'role'     => $role,
        ]);

        Auth::login($admin);

        return redirect()->route('AdminHome');
    }

    // public function login()
    // {

    // }




    // there is a problem -- in this controller



}
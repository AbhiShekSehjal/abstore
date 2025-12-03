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
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ]);

        $role = $request->input('role') ?? 'admin';

        $admin = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => $role,
        ]);

        Auth::login($admin);

        return redirect()->route('AdminHome');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            if (Auth::user()->role !== 'admin') {

                return back()->withErrors([
                    'email' => "Only admins can login!",
                ])->onlyInput('email');

            }

            return redirect()->route('AdminHome');
        }

        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('AdminLoginPage');
    }

}
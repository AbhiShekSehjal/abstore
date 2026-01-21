<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use App\Models\admin\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

    public function submit(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $data = $request->only('name', 'email', 'message');
        $settings = Setting::first(); // site logo, name, email, etc.

        Mail::to($settings->email ?? 'shek54112@gmail.com')
            ->send(new ContactFormMail($data, $settings));

        return back()->with('success', 'Message sent successfully!');
    }
}

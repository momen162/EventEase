<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (auth()->user()->is_admin) {
                return redirect()->route('admin.events.index');
            } else {
                Auth::logout();
                return redirect()->route('admin.login')->withErrors(['email' => 'You are not authorized to access the admin panel.']);
            }
        }

        return redirect()->route('admin.login')->withErrors(['email' => 'Invalid login credentials.']);
    }
}

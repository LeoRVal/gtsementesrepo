<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AuthController extends Controller
{
    // Login page
    public function login() {
        return view('login');
    }

    // Login functionality
    public function attempt(Request $request) {
        // Creates variable for credentials
        $credentials = [
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ];

        /* Checks if credentials are acceptable */

        // IF email and password are ok, go to Dashboard
        if (Auth::attempt($credentials)) {
            Session::regenerateToken();
            return redirect()->route('dashboard');
        }

        // IF email and/or password are incorrect, send error message
        return back()->withErrors(['message', 'Email and/or password are incorrect.'])->withInput($request->only('email'));
    }


    // Logout functionality
    public function logout() {
        // Logging out invalidates current session's token
        Session::invalidate();
        Session::regenerateToken();

        // Send user back to login screen
        return redirect()->route('login');
    }


    public function dashboard() {
        return view('dashboard');
    }
}

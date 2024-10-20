<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class AdminAuthController extends Controller
{

    public function create () {
        return Inertia::render('Admin/Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    public function login (Request $request) {

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, $request->role => 'Administrator'])) {

            return to_route('admin.dashboard');
        }

        return to_route('admin.login')->with('error', 'Invalid Credentials');

    }

    public function logout (Request $request) {
        Auth::guard('web')->logout();
        $request->session()->invalidate();

        return to_route('admin.login');

    }
}

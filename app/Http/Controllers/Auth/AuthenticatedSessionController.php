<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        // Attempt to authenticate
        if (!Auth::attempt($request->only('email', 'password'))) {
            return redirect()->back()->with('error', 'The provided credentials do not match our records.');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Check if user has roles
        if (!$user->roles || $user->roles->isEmpty()) {
            Auth::logout();
            return redirect()->back()->with('error', 'You do not have any roles assigned. Please contact the administrator.');
        }

        return redirect()->intended(route('dashboard'));
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return to_route('login');
    }
}

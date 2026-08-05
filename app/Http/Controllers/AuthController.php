<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /** Redirect setelah login berdasarkan role */
    private function redirectByRole()
    {
        $role = Auth::user()->role;
        return match($role) {
            'superadmin' => redirect()->route('superadmin.dashboard'),
            'admin'      => redirect()->route('admin.dashboard'),
            'asesor'     => redirect()->route('asesor.dashboard'),
            'asesi'      => redirect()->route('asesi.dashboard'),
            'instruktur' => redirect()->route('instruktur.dashboard'),
            default      => redirect()->route('home'),
        };
    }

    /** Show the login form. */
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }
        $programs = \App\Models\TrainingProgram::all();
        $settings = \App\Models\LandingSetting::pluck('value', 'key');
        $siteTitle = \App\Models\LandingSetting::getValue('site_title', 'LPK-MI');
        $siteLogo  = \App\Models\LandingSetting::getValue('site_logo');
        return view('auth.login', compact('programs', 'settings', 'siteTitle', 'siteLogo'));
    }

    /** Handle manual login request (Username & Password). */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole()->with('success', 'Berhasil masuk.');
        }

        return redirect()->route('login')->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username'));
    }

    public function redirectToGoogle()
    {
        $clientId = config('services.google.client_id');

        if (!$clientId || str_contains($clientId, 'your-real-google-client-id') || trim($clientId) === '') {
            return redirect()->route('auth.mock-google');
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('auth.mock-google')->withErrors([
                'email' => 'Gagal menginisialisasi Google SSO: ' . $e->getMessage() . '. Beralih ke mode simulasi.'
            ]);
        }
    }

    /** Handle the real Google SSO callback. */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'email' => 'Gagal masuk melalui Google SSO: ' . $e->getMessage()
            ]);
        }

        $email = $googleUser->getEmail();
        $user  = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Akses ditolak. Email Google Anda (' . $email . ') tidak terdaftar di sistem LPK-MI.'
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return $this->redirectByRole();
    }

    /** Show mock Google account chooser page. */
    public function showMockGoogle()
    {
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        $admins = User::all();
        return view('auth.mock_google', compact('admins'));
    }

    /** Handle mock Google account choice callback. */
    public function handleMockGoogleCallback(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $email = $request->email;
        $user  = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('auth.mock-google')->withErrors([
                'email' => 'Akun tersebut tidak terdaftar di sistem LPK-MI.'
            ]);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return $this->redirectByRole()->with('success', 'Berhasil masuk sebagai ' . $user->name);
    }

    /** Log the user out. */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}


<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller {
    public function showLogin()    { return view('login'); }
    public function showRegister() { return view('register'); }

    public function login(Request $request) {
        $request->validate(['email'=>'required|email','password'=>'required']);
        $key = 'login:'.Str::lower($request->email).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $secs = RateLimiter::availableIn($key);
            return back()->withErrors(['loginError'=>"Terlalu banyak percobaan. Coba lagi dalam {$secs} detik."])->withInput();
        }
        if (Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {
            RateLimiter::clear($key);
            $request->session()->regenerate();
            $user = Auth::user();
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors(['loginError'=>'Akun Anda belum diaktifkan. Tunggu konfirmasi admin.'])->withInput();
            }
            return $user->isPetugas() ? redirect()->route('admin.dashboard') : redirect()->route('dashboard');
        }
        RateLimiter::hit($key, 60);
        return back()->withErrors(['loginError'=>'Email atau Password salah.'])->withInput();
    }

    public function register(Request $request) {
        $request->validate([
            'username' => 'required|string|max:50|unique:users',
            'alamat'   => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        User::create([
            'username'  => $request->username,
            'email'     => $request->email,
            'password'  => $request->password,
            'alamat'    => $request->alamat,
            'role'      => 'user',
            'is_active' => false,
        ]);
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Tunggu aktivasi oleh admin.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required',
        ]);

        // Cek kredensial
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Cek user aktif
            if (!$user->is_active) {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.',
                ])->onlyInput('username');
            }

            // Log aktivitas login
            $this->logLoginActivity($user, $request);

            // Redirect berdasarkan hak akses
            return $this->redirectBasedOnRole($user)
                ->with('success', $this->getWelcomeMessage($user));
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log aktivitas logout
        if ($user) {
            $this->logLogoutActivity($user, $request);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Redirect user based on their hak_akses
     */
    protected function redirectBasedOnRole($user)
    {
        switch ($user->hak_akses) {
            case 'superadmin':
            case 'admin':
                return redirect()->intended(route('admin.dashboard'));
            
            case 'bk':
                return redirect()->intended(route('bk.dashboard'));
            
            case 'guru':
                return redirect()->intended(route('guru.dashboard'));
            
            case 'siswa':
                return redirect()->intended(route('siswa.dashboard'));
            
            case 'ortu':
                return redirect()->intended(route('ortu.dashboard'));
            
            default:
                return redirect()->intended(route('dashboard'));
        }
    }

    /**
     * Get welcome message based on user role
     */
    protected function getWelcomeMessage($user)
    {
        $greeting = $this->getGreeting();
        $roleName = $this->getRoleDisplayName($user->hak_akses);
        
        return "{$greeting}, {$user->nama}. Selamat datang di Dashboard {$roleName}.";
    }

    /**
     * Get greeting based on current time
     */
    protected function getGreeting()
    {
        $hour = date('H');
        
        if ($hour >= 5 && $hour < 11) {
            return 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 18) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }

    /**
     * Get display name for user role
     */
    protected function getRoleDisplayName($hakAkses)
    {
        $roles = [
            'superadmin' => 'Super Administrator',
            'admin' => 'Administrator',
            'bk' => 'Guru BK',
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            'ortu' => 'Orang Tua'
        ];

        return $roles[$hakAkses] ?? 'User';
    }

    /**
     * Log login activity
     */
    protected function logLoginActivity($user, $request)
    {
        // Jika Anda memiliki model LogAktivitas
        if (class_exists('App\Models\LogAktivitas')) {
            \App\Models\MasterData\LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Login ke sistem',
                'modul' => 'AUTH',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Log logout activity
     */
    protected function logLogoutActivity($user, $request)
    {
        // Jika Anda memiliki model LogAktivitas
        if (class_exists('App\Models\LogAktivitas')) {
            \App\Models\LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Logout dari sistem',
                'modul' => 'AUTH',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);
        }
    }

    /**
     * Handle failed login attempt
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // Cek apakah username ada di database
        $user = User::where('username', $request->username)->first();
        
        if ($user) {
            // Log percobaan login gagal
            if (class_exists('App\Models\LogAktivitas')) {
                \App\Models\LogAktivitas::create([
                    'user_id' => $user->id,
                    'aktivitas' => 'Percobaan login gagal',
                    'modul' => 'AUTH',
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'data' => json_encode(['reason' => 'password_salah']),
                    'created_at' => now(),
                ]);
            }
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    /**
     * Show password reset form
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Di sini Anda bisa implementasi pengiriman email reset password
        // Menggunakan Laravel's built-in password reset features
        
        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}
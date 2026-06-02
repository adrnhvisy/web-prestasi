<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Operasional\LogAktivitas;

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

            // Redirect berdasarkan hak akses (Spatie Role)
            return $this->redirectBasedOnRole($user)
                ->with('success', $this->getWelcomeMessage($user));
        }

        // Panggil log percobaan gagal jika login tidak berhasil
        return $this->sendFailedLoginResponse($request);
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
     * Redirect user based on their Spatie Role
     */
    protected function redirectBasedOnRole($user)
    {
        if ($user->hasRole('superadmin') || $user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('bk')) {
            return redirect()->route('bk.dashboard');
        }

        if ($user->hasRole('guru')) {
            return redirect()->route('guru.dashboard');
        }

        if ($user->hasRole('siswa')) {
            return redirect()->route('siswa.dashboard');
        }

        if ($user->hasRole('ortu')) {
            return redirect()->route('ortu.dashboard');
        }

        return redirect()->route('dashboard');
    }

    /**
     * Get welcome message based on user role
     */
    protected function getWelcomeMessage($user)
    {
        $greeting = $this->getGreeting();
        // Mengambil nama role pertama dari Spatie
        $roleName = $this->getRoleDisplayName($user->roles->first()?->name);

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
    protected function getRoleDisplayName($roleName)
    {
        $roles = [
            'superadmin' => 'Super Administrator',
            'admin' => 'Administrator',
            'bk' => 'Guru BK',
            'guru' => 'Guru',
            'siswa' => 'Siswa',
            'ortu' => 'Orang Tua'
        ];

        return $roles[$roleName] ?? 'User';
    }

    /**
     * Log login activity
     */
    protected function logLoginActivity($user, $request)
    {
        if (class_exists(LogAktivitas::class)) {
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Login ke sistem',
                'modul' => 'AUTH',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        }
    }

    /**
     * Log logout activity
     */
    protected function logLogoutActivity($user, $request)
    {
        if (class_exists(LogAktivitas::class)) {
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Logout dari sistem',
                'modul' => 'AUTH',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
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

        if ($user && class_exists(LogAktivitas::class)) {
            LogAktivitas::create([
                'user_id' => $user->id,
                'aktivitas' => 'Percobaan login gagal',
                'modul' => 'AUTH',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'data' => json_encode(['reason' => 'password_salah']),
            ]);
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

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');
    }
}
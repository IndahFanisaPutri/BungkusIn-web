<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\User;
use Collator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AuthController extends Controller
{
    /* ------------------------------ REGISTER ------------------------------ */

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20', 'regex:/^[0-9+\-\s]+$/'],
            'password' => ['required', 'confirmed', Password::min(8)],
            // Admin TIDAK boleh mendaftar lewat form publik -> hanya customer/merchant
            'role'     => ['required', 'in:customer,merchant'],
            // Data toko wajib hanya jika mendaftar sebagai merchant
            'store_name' => ['required_if:role,merchant', 'nullable', 'string', 'max:255'],
            'address'    => ['required_if:role,merchant', 'nullable', 'string', 'max:500'],
        ], [
            'email.unique'            => 'Email ini sudah terdaftar.',
            'password.confirmed'      => 'Konfirmasi password tidak cocok.',
            'store_name.required_if'  => 'Nama toko wajib diisi untuk akun merchant.',
            'address.required_if'     => 'Alamat toko wajib diisi untuk akun merchant.',
        ]);

        // Transaksi: user & profil toko harus sukses bersama-sama
        $user = DB::transaction(function () use ($validated) {
            $user = User::create([
                'name'     => $validated['name'],
                'email'    => $validated['email'],
                'phone'    => $validated['phone'] ?? null,
                'role'     => $validated['role'],
                'password' => $validated['password'], // di-hash otomatis oleh cast 'hashed' di model User
            ]);

            if ($user->role === 'merchant') {
                Merchant::create([
                    'user_id'             => $user->id,
                    'store_name'          => $validated['store_name'],
                    'address'             => $validated['address'],
                    'status_verification' => 'pending', // menunggu verifikasi admin
                ]);
            }

            return $user;
        });

        // Auto-login setelah register
        Auth::login($user);
        $request->session()->regenerate();

        return $this->redirectUserByRole($user);
    }

    /* ------------------------------- LOGIN -------------------------------- */

    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Cegah session fixation
            $request->session()->regenerate();

            return $this->redirectUserByRole(Auth::user());
        }

        // Pesan error generik (tidak membocorkan apakah email terdaftar atau tidak)
        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    /* ------------------------------- LOGOUT ------------------------------- */

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();      // hapus semua data session
        $request->session()->regenerateToken(); // token CSRF baru

        return redirect('/');
    }

    /* ------------------------------ HELPER -------------------------------- */

    // Pengalihan halaman berdasarkan role user
    private function redirectUserByRole(User $user): RedirectResponse
    {
        return match ($user->role) {
            'admin'    => redirect('/admin/dashboard'),
            'merchant' => redirect('/merchant/dashboard'),
            default    => redirect('/katalog'), // customer
        };
    }
}

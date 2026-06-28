<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $role = session('hak_akses', 'petugas');

        if ($role === 'pemilik') {
            $user = DB::table('users')->where('username', $this->username)->first();

            if (!$user || !Hash::check($this->password, $user->password)) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'username' => 'Username atau password salah.',
                ]);
            }

            Auth::loginUsingId($user->id);

        } else {
            $petugas = DB::table('petugas')
                ->where('username', $this->username)
                ->first();

            if (!$petugas || !Hash::check($this->password, $petugas->password)) {
                RateLimiter::hit($this->throttleKey());
                throw ValidationException::withMessages([
                    'username' => 'Username atau password salah.',
                ]);
            }

            session([
                'petugas_login'    => true,
                'petugas_id'       => $petugas->id_petugas,
                'petugas_nama'     => $petugas->nama_petugas,
                'petugas_username' => $petugas->username,
            ]);

            // Login pakai user pemilik agar bisa melewati middleware auth
            $userPemilik = DB::table('users')->where('id', 1)->first();
            if ($userPemilik) {
                Auth::loginUsingId($userPemilik->id);
            }
        }

        RateLimiter::clear($this->throttleKey());
    }

    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')) . '|' . $this->ip());
    }
}

<x-guest-layout>
    @php
        $role = session('hak_akses', 'petugas');
        $roleTitle = ($role === 'pemilik') ? 'Pemilik' : 'Petugas';
    @endphp

    <div class="w-full">
        <!-- HEADER BIRU TUA -->
        <div class="bg-[#0b4d87] text-white py-10 flex flex-col items-center justify-center text-center shadow-md -mx-6 -mt-6 sm:-mx-8 sm:-mt-8 mb-8">
            <div class="w-14 h-14 bg-white/10 rounded-full flex items-center justify-center mb-3 font-bold text-xl">PD</div>
            <h1 class="text-lg font-semibold tracking-wide">PD. Lancar Jaya Ciwidey</h1>
            <span class="mt-2 px-4 py-1 bg-white/15 text-xs rounded-full text-gray-200 border border-white/20">
                Masuk sebagai {{ $roleTitle }}
            </span>
        </div>

        <!-- FORM -->
        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <h2 class="text-center text-base text-gray-800 mb-6 font-normal">Masuk ke dalam sistem</h2>

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input id="username"
                       type="text"
                       name="username"
                       placeholder="Masukkan username"
                       value="{{ old('username') }}"
                       required
                       autofocus
                       autocomplete="username"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#0b4d87] focus:outline-none focus:ring-1 focus:ring-[#0b4d87] text-gray-700 placeholder-gray-400 text-sm transition-colors" />
                <x-input-error :messages="$errors->get('username')" class="mt-1" />
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input id="password"
                       type="password"
                       name="password"
                       placeholder="Masukkan password"
                       required
                       autocomplete="current-password"
                       class="w-full px-3 py-2.5 border border-gray-300 rounded-lg focus:border-[#0b4d87] focus:outline-none focus:ring-1 focus:ring-[#0b4d87] text-gray-700 placeholder-gray-400 text-sm transition-colors" />
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <!-- Tombol Login -->
            <div class="pt-2">
                <button type="submit" class="w-full bg-[#0b4d87] hover:bg-[#093e6d] text-white font-medium py-2.5 px-4 rounded-lg transition-colors duration-200 text-sm tracking-wide">
                    Login
                </button>
            </div>

            <div class="text-center pt-1">
                <a href="{{ route('pilihakses') }}" class="text-sm text-[#0b4d87] hover:underline font-medium">
                    Kembali ke pilihan hak akses
                </a>
            </div>
        </form>

        <!-- FOOTER -->
        <div class="mt-8 pt-4 text-center text-xs text-gray-400 border-t border-gray-100">
            &copy; 2024 PD. Lancar Jaya Ciwidey
        </div>
    </div>
</x-guest-layout>

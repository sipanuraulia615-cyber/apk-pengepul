<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beranda Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-50 text-gray-800 -mt-6">
        <!-- SIDEBAR PETUGAS -->
        <aside class="w-64 bg-[#0d47a1] text-white flex flex-col justify-between p-6 shadow-lg shrink-0">
            <div>
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-blue-400 bg-opacity-30 rounded-md flex items-center justify-center font-bold text-white">PD</div>
                    <div>
                        <h2 class="font-bold text-sm leading-tight tracking-wide">PD. Lancar Jaya</h2>
                        <p class="text-xs text-blue-200">Ciwidey</p>
                    </div>
                </div>

                <div class="mb-4">
                    <p class="text-[10px] uppercase tracking-wider text-blue-200 font-semibold mb-3 px-2">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 bg-blue-900 bg-opacity-40 text-white rounded-md text-sm font-medium">Beranda</a>
                        <a href="{{ route('transaksibeli') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Transaksi Beli</a>
                        <a href="{{ route('transaksijual') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Transaksi Jual</a>
                        <a href="{{ route('datapetani') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Data Petani</a>
                        <a href="{{ route('datasayur') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Data Sayuran</a>
                    </nav>
                </div>
            </div>

            <!-- PROFIL & LOGOUT -->
            <div class="border-t border-blue-800 pt-4">
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-9 h-9 bg-blue-400 bg-opacity-40 rounded-full flex items-center justify-center font-semibold text-sm">
                        {{ substr(session('petugas_nama') ?? Auth::user()->name ?? 'P', 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-semibold">{{ session('petugas_nama') ?? Auth::user()->name ?? 'Petugas' }}</p>
                        <p class="text-xs text-blue-200">Petugas</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-300 hover:text-red-400 font-medium transition pl-1 flex items-center space-x-1">
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-10 bg-white">
            <header class="mb-10">
                <h1 class="text-2xl text-gray-900 font-normal">Selamat datang, {{ session('petugas_nama') ?? Auth::user()->name ?? 'Petugas' }}</h1>
                <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
            </header>

            <!-- CARD RINGKASAN DATA (BISA DIKLIK) -->
            <section class="grid grid-cols-3 gap-8 mb-12 max-w-4xl">
                <!-- Box Transaksi Beli -->
                <a href="{{ route('transaksibeli') }}" class="p-4 block border border-transparent rounded-xl hover:border-gray-200 hover:bg-gray-50 transition group">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-6 h-6 bg-blue-100 rounded flex items-center justify-center text-blue-600 font-bold text-xs">↓</div>
                        <span class="text-xs font-medium text-gray-700 group-hover:text-blue-600 transition">Transaksi Beli</span>
                    </div>
                    <div class="text-4xl font-normal text-gray-900 mb-1">{{ $totalBeli ?? 0 }}</div>
                    <span class="text-xs text-gray-400">Hari ini</span>
                </a>

                <!-- Box Transaksi Jual -->
                <a href="{{ route('transaksijual') }}" class="p-4 block border border-transparent rounded-xl hover:border-gray-200 hover:bg-gray-50 transition group">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-6 h-6 bg-green-100 rounded flex items-center justify-center text-green-600 font-bold text-xs">↑</div>
                        <span class="text-xs font-medium text-gray-700 group-hover:text-green-600 transition">Transaksi Jual</span>
                    </div>
                    <div class="text-4xl font-normal text-gray-900 mb-1">{{ $totalJual ?? 0 }}</div>
                    <span class="text-xs text-gray-400">Hari ini</span>
                </a>

                <!-- Box Total Petani -->
                <a href="{{ route('datapetani') }}" class="p-4 block border border-transparent rounded-xl hover:border-gray-200 hover:bg-gray-50 transition group">
                    <div class="flex items-center space-x-3 mb-2">
                        <div class="w-6 h-6 bg-orange-100 rounded flex items-center justify-center text-orange-600 font-bold text-xs">👥</div>
                        <span class="text-xs font-medium text-gray-700 group-hover:text-orange-600 transition">Total Petani</span>
                    </div>
                    <div class="text-4xl font-normal text-gray-900 mb-1">{{ $totalPetani ?? 0 }}</div>
                    <span class="text-xs text-gray-400">Terdaftar</span>
                </a>
            </section>

            <!-- TABEL TRANSAKSI TERBARU -->
            <section class="max-w-4xl">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-base font-medium text-gray-900">Transaksi terbaru</h2>
                    <a href="{{ route('transaksibeli') }}" class="text-xs text-blue-600 hover:underline">Lihat semua riwayat</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-normal w-1/5">Petani/Pelanggan</th>
                                <th class="pb-3 font-normal w-1/5">Sayuran</th>
                                <th class="pb-3 font-normal w-1/5">Total</th>
                                <th class="pb-3 font-normal w-1/5">Waktu</th>
                                <th class="pb-3 font-normal w-1/5">Jenis</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($transaksiTerbaru ?? [] as $item)
                                <tr class="border-b border-gray-50">
                                    <td class="py-3.5">{{ $item->nama_subjek }}</td>
                                    <td class="py-3.5">{{ $item->nama_sayur }}</td>
                                    <td class="py-3.5">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                    <td class="py-3.5">{{ $item->waktu }}</td>
                                    <td class="py-3.5">
                                        @if($item->jenis == 'Beli')
                                            <span class="px-3 py-1 text-xs bg-blue-50 text-blue-500 rounded-full font-medium">Beli</span>
                                        @else
                                            <span class="px-3 py-1 text-xs bg-green-50 text-green-500 rounded-full font-medium">Jual</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-400 text-sm">Belum ada transaksi hari ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="flex min-h-screen bg-gray-50 text-gray-800 -mt-6">
        <!-- SIDEBAR KIRI (PEMILIK) -->
        <aside class="w-64 bg-[#0d47a1] text-white flex flex-col justify-between p-6 shadow-lg shrink-0">
            <div>
                <!-- Logo & Nama Usaha -->
                <div class="flex items-center space-x-3 mb-8">
                    <div class="w-10 h-10 bg-blue-400 bg-opacity-30 rounded-md flex items-center justify-center font-bold text-white">PD</div>
                    <div>
                        <h2 class="font-bold text-sm leading-tight tracking-wide">PD. Lancar Jaya</h2>
                        <p class="text-xs text-blue-200">Ciwidey</p>
                    </div>
                </div>

                <!-- Menu Navigasi -->
                <div class="mb-4">
                    <p class="text-[10px] uppercase tracking-wider text-blue-200 font-semibold mb-3 px-2">Menu Utama</p>
                    <nav class="space-y-1">
                        <a href="{{ route('dashboardpemilik') }}"
                           class="flex items-center px-4 py-2.5 rounded-md text-sm {{ request()->routeIs('dashboardpemilik') ? 'bg-blue-900 bg-opacity-40 font-medium' : 'text-blue-100 hover:bg-blue-800' }}">
                            Beranda
                        </a>

                        <a href="{{ route('stoksayuran') }}"
                           class="flex items-center px-4 py-2.5 rounded-md text-sm {{ request()->routeIs('stoksayuran') ? 'bg-blue-900 bg-opacity-40 font-medium' : 'text-blue-100 hover:bg-blue-800' }}">
                            Stok Sayuran
                        </a>

                        <a href="{{ route('laporan.beli') }}"
                           class="flex items-center px-4 py-2.5 rounded-md text-sm pl-6 {{ request()->routeIs('laporan.beli') ? 'bg-blue-900 bg-opacity-40 font-medium' : 'text-blue-100 hover:bg-blue-800' }}">
                            • Laporan Beli
                        </a>
                        <a href="{{ route('laporan.jual') }}"
                           class="flex items-center px-4 py-2.5 rounded-md text-sm pl-6 {{ request()->routeIs('laporan.jual') ? 'bg-blue-900 bg-opacity-40 font-medium' : 'text-blue-100 hover:bg-blue-800' }}">
                            • Laporan Jual
                        </a>

                        <a href="{{ route('datapetugas') }}"
                           class="flex items-center px-4 py-2.5 rounded-md text-sm {{ request()->routeIs('datapetugas') ? 'bg-blue-900 bg-opacity-40 font-medium' : 'text-blue-100 hover:bg-blue-800' }}">
                            Data Petugas
                        </a>
                        <a href="{{ route('asistenchatbot') }}"
                           class="flex items-center px-4 py-2.5 rounded-md text-sm {{ request()->routeIs('asistenchatbot') ? 'bg-blue-900 bg-opacity-40 font-medium' : 'text-blue-100 hover:bg-blue-800' }}">
                            Asisten Chatbot
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Logout -->
            <div class="border-t border-blue-800 pt-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-300 hover:text-red-400 font-medium transition pl-1">Keluar</button>
                </form>
            </div>
        </aside>

        <!-- KONTEN UTAMA -->
        <main class="flex-1 p-10 bg-white">
            <header class="mb-10">
                <h1 class="text-xl font-medium text-gray-900">Selamat datang, {{ Auth::user()->name }}</h1>
                <p class="text-xs text-gray-500 mt-0.5">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}</p>
            </header>

            <!-- STATISTIK (DAPAT DIKLIK & DINAMIS) -->
            <div class="grid grid-cols-4 gap-6 mb-12">
                <!-- Total Pembelian -->
                <a href="{{ route('laporan.beli') }}" class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-blue-400 hover:bg-blue-50/30 transition block group">
                    <p class="text-[11px] text-gray-500 font-medium group-hover:text-blue-600">Total Pembelian</p>
                    <p class="text-3xl font-semibold text-gray-900 my-1">{{ $totalBeli ?? 0 }}</p>
                    <p class="text-[10px] text-gray-400">Hari ini</p>
                </a>

                <!-- Total Penjualan -->
                <a href="{{ route('laporan.jual') }}" class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-green-400 hover:bg-green-50/30 transition block group">
                    <p class="text-[11px] text-gray-500 font-medium group-hover:text-green-600">Total Penjualan</p>
                    <p class="text-3xl font-semibold text-gray-900 my-1">{{ $totalJual ?? 0 }}</p>
                    <p class="text-[10px] text-gray-400">Hari ini</p>
                </a>

                <!-- Jenis Stok -->
                <a href="{{ route('stoksayuran') }}" class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-orange-400 hover:bg-orange-50/30 transition block group">
                    <p class="text-[11px] text-gray-500 font-medium group-hover:text-orange-600">Jenis Stok</p>
                    <p class="text-3xl font-semibold text-gray-900 my-1">{{ $totalSayur ?? 0 }}</p>
                    <p class="text-[10px] text-gray-400">Jenis sayuran</p>
                </a>

                <!-- Total Petugas -->
                <a href="{{ route('datapetugas') }}" class="p-4 bg-white rounded-xl border border-gray-100 shadow-sm hover:border-purple-400 hover:bg-purple-50/30 transition block group">
                    <p class="text-[11px] text-gray-500 font-medium group-hover:text-purple-600">Total Petugas</p>
                    <p class="text-3xl font-semibold text-gray-900 my-1">{{ $totalPetugas ?? 0 }}</p>
                    <p class="text-[10px] text-gray-400">Aktif</p>
                </a>
            </div>
        </main>
    </div>
</x-app-layout>

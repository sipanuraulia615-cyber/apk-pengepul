<aside class="w-64 bg-[#0d47a1] text-white flex flex-col justify-between p-6 shadow-lg shrink-0">
    <div>
        <div class="flex items-center space-x-3 mb-8">
            <div class="w-10 h-10 bg-blue-400 bg-opacity-30 rounded-md flex items-center justify-center font-bold text-white">PD</div>
            <div>
                <h2 class="font-bold text-sm leading-tight tracking-wide">PD. Lancar Jaya</h2>
                <p class="text-xs text-blue-200">Ciwidey</p>
            </div>
        </div>

        <p class="text-[10px] uppercase tracking-wider text-blue-200 font-semibold mb-3 px-2">Menu Utama</p>
        <nav class="space-y-1">
            <a href="{{ route('dashboardpemilik') }}"
               class="flex items-center px-4 py-2.5 rounded-md text-sm transition {{ request()->is('pemilik') ? 'bg-blue-900 bg-opacity-40 font-medium text-white' : 'text-blue-100 hover:bg-blue-800 hover:bg-opacity-30' }}">
                Beranda
            </a>
            <a href="{{ route('stoksayuran') }}"
               class="flex items-center px-4 py-2.5 rounded-md text-sm transition {{ request()->routeIs('stoksayuran') ? 'bg-blue-900 bg-opacity-40 font-medium text-white' : 'text-blue-100 hover:bg-blue-800 hover:bg-opacity-30' }}">
                Stok Sayuran
            </a>
            <a href="{{ route('laporan.beli') }}"
               class="flex items-center px-4 py-2.5 rounded-md text-sm pl-6 transition {{ request()->routeIs('laporan.beli') ? 'bg-blue-900 bg-opacity-40 font-medium text-white' : 'text-blue-100 hover:bg-blue-800 hover:bg-opacity-30' }}">
                • Laporan Beli
            </a>
            <a href="{{ route('laporan.jual') }}"
               class="flex items-center px-4 py-2.5 rounded-md text-sm pl-6 transition {{ request()->routeIs('laporan.jual') ? 'bg-blue-900 bg-opacity-40 font-medium text-white' : 'text-blue-100 hover:bg-blue-800 hover:bg-opacity-30' }}">
                • Laporan Jual
            </a>
            <a href="{{ route('datapetugas') }}"
               class="flex items-center px-4 py-2.5 rounded-md text-sm transition {{ request()->routeIs('datapetugas') ? 'bg-blue-900 bg-opacity-40 font-medium text-white' : 'text-blue-100 hover:bg-blue-800 hover:bg-opacity-30' }}">
                Data Petugas
            </a>
            <a href="{{ route('asistenchatbot') }}"
               class="flex items-center px-4 py-2.5 rounded-md text-sm transition {{ request()->routeIs('asistenchatbot') ? 'bg-blue-900 bg-opacity-40 font-medium text-white' : 'text-blue-100 hover:bg-blue-800 hover:bg-opacity-30' }}">
                Asisten Chatbot
            </a>
        </nav>
    </div>

     <!-- PROFIL & LOGOUT -->
    <div class="border-t border-blue-800 pt-4">
        <div class="flex items-center space-x-3 mb-3">
            <div class="w-9 h-9 bg-blue-400 bg-opacity-40 rounded-full flex items-center justify-center font-semibold text-sm">
                {{ substr(Auth::user()->name ?? 'P', 0, 1) }}
            </div>
            <div>
                <p class="text-sm font-semibold">{{ session('petugas_pemilik') ?? Auth::user()->name ?? 'Pemilik' }}</p>
                <p class="text-xs text-blue-200">Pemilik</p>
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

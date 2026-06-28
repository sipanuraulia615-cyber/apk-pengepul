<x-app-layout>
    <div class="flex min-h-screen bg-gray-50 text-gray-800 -mt-6">
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
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Beranda</a>
                        <a href="{{ route('transaksibeli') }}" class="flex items-center px-4 py-2.5 bg-blue-900 bg-opacity-40 text-white rounded-md text-sm font-medium">Transaksi Beli</a>
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

        <main class="flex-1 p-10 bg-white">
            <header class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-xl font-medium text-gray-900">Transaksi Beli</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Input pembelian sayuran dari petani</p>
                </div>
            </header>

            @if(session('success'))
                <div class="max-w-4xl mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <section class="max-w-4xl bg-white rounded-lg mb-12">
                <h2 id="formTitle" class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-6">Form Transaksi Pembelian</h2>

                <form id="formTransaksiBeli" method="POST" action="{{ route('transaksibeli.store') }}">
                    @csrf
                    <div id="methodField"></div>

                    <div class="grid grid-cols-2 gap-x-12 gap-y-6 text-sm mb-8">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5">Nama Petani</label>
                            <select name="id_petani" id="id_petani" onchange="updateIdPetani(this)" required class="w-full border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-0 text-sm">
                                <option value="">-- Pilih Petani --</option>
                                @foreach($data_petani ?? [] as $petani)
                                    <option value="{{ $petani->id_petani }}" data-id="{{ $petani->id_petani }}">
                                        {{ $petani->nama_petani }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-500 font-medium mb-1.5">ID Petani</label>
                            <input type="text" id="display_id_petani" value="-" disabled class="w-full border-none bg-transparent p-2 text-gray-700 font-mono font-medium focus:ring-0">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5">Nama Sayuran</label>
                            <select name="id_sayur" id="id_sayur" onchange="updateIdSayur(this)" required class="w-full border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-0 text-sm">
                                <option value="">-- Pilih Sayuran --</option>
                                @foreach($data_sayur ?? [] as $sayur)
                                    <option value="{{ $sayur->id_sayur }}" data-id="S{{ str_pad($sayur->id_sayur, 3, '0', STR_PAD_LEFT) }}">
                                        {{ $sayur->nama_sayur }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-500 font-medium mb-1.5">ID Sayuran</label>
                            <input type="text" id="display_id_sayur" value="-" disabled class="w-full border-none bg-transparent p-2 text-gray-700 font-mono font-medium focus:ring-0">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5">Harga / kg (Rp)</label>
                            <input type="number" name="harga_per_kg" id="harga_per_kg" oninput="hitungTotal()" placeholder="Contoh: 5000" required class="w-full border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-0 text-sm">
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5">Jumlah (kg)</label>
                            <input type="number" name="jumlah_kg" id="jumlah_kg" oninput="hitungTotal()" placeholder="Contoh: 200" required class="w-full border-gray-300 rounded-lg p-2 focus:border-blue-500 focus:ring-0 text-sm">
                        </div>

                        <div>
                            <label class="block text-gray-700 font-medium mb-1.5">Total Bayar (Rp)</label>
                            <div id="display_total_bayar" class="p-2 font-bold text-gray-900 text-base">Rp 0</div>
                        </div>
                        <div>
                            <label class="block text-gray-500 font-medium mb-1.5">Waktu Pembelian</label>
                            <div id="display_waktu" class="p-2 text-gray-600 font-mono text-sm"></div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 border-t border-gray-100 pt-4">
                        <button type="button" onclick="resetToTambah()" class="px-5 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium">Batal</button>
                        <button type="submit" id="btnSimpan" class="px-6 py-2 bg-[#0b468c] text-white rounded-lg text-sm font-medium shadow hover:bg-blue-800 transition">Simpan</button>
                    </div>
                </form>
            </section>

            <section class="max-w-4xl">
                <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-4">Riwayat Transaksi Beli</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs text-gray-400 border-b border-gray-200">
                                <th class="pb-3 font-medium">ID</th>
                                <th class="pb-3 font-medium">Petani</th>
                                <th class="pb-3 font-medium">Sayuran</th>
                                <th class="pb-3 font-medium">Harga/kg</th>
                                <th class="pb-3 font-medium">Jumlah</th>
                                <th class="pb-3 font-medium">Total</th>
                                <th class="pb-3 font-medium">Waktu</th>
                                <th class="pb-3 font-medium text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($transaksi_beli ?? [] as $tb)
                            <tr class="border-b border-gray-100 hover:bg-gray-50/50 transition">
                                <td class="py-4"><span class="px-2 py-0.5 text-xs bg-blue-50 text-blue-600 rounded font-mono font-medium">BEL{{ sprintf('%03d', $tb->id_beli) }}</span></td>
                                <td class="py-4 font-medium">{{ $tb->nama_petani }}</td>
                                <td class="py-4">{{ $tb->nama_sayur }}</td>
                                <td class="py-4">Rp {{ number_format($tb->harga_per_kg, 0, ',', '.') }}</td>
                                <td class="py-4">{{ $tb->jumlah_kg }} kg</td>
                                <td class="py-4 font-semibold">Rp {{ number_format($tb->total_bayar, 0, ',', '.') }}</td>
                                <td class="py-4 text-xs text-gray-500 font-mono">{{ date('d/m H:i', strtotime($tb->waktu_beli)) }}</td>
                                <td class="py-4 flex items-center justify-center space-x-3">
                                    <button type="button" onclick="pemicuEdit('{{ $tb->id_beli }}', '{{ $tb->id_petani }}', '{{ $tb->id_sayur }}', '{{ $tb->harga_per_kg }}', '{{ $tb->jumlah_kg }}')" class="text-xs text-blue-600 hover:underline font-medium">Ubah</button>

                                    <form method="POST" action="{{ route('transaksibeli.destroy', $tb->id_beli) }}" onsubmit="return confirm('Hapus data transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-8 text-gray-400 text-xs italic">Belum ada transaksi pembelian hari ini.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        function tampilkanWaktu() {
            const sekarang = new Date();
            const opsi = { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            document.getElementById('display_waktu').innerText = sekarang.toLocaleString('id-ID', opsi).replace(/\./g, ':');
        }
        setInterval(tampilkanWaktu, 1000);
        tampilkanWaktu();

        function updateIdPetani(select) {
            const selectedOption = select.options[select.selectedIndex];
            const id = selectedOption.getAttribute('data-id');
            document.getElementById('display_id_petani').value = id ? 'A' + String(id).padStart(3, '0') : '-';
        }

        function updateIdSayur(select) {
            const selectedOption = select.options[select.selectedIndex];
            const id = selectedOption.getAttribute('data-id');
            document.getElementById('display_id_sayur').value = id ? id : '-';
        }

        function hitungTotal() {
            const harga = parseFloat(document.getElementById('harga_per_kg').value) || 0;
            const jumlah = parseFloat(document.getElementById('jumlah_kg').value) || 0;
            const total = harga * jumlah;
            document.getElementById('display_total_bayar').innerText = 'Rp ' + total.toLocaleString('id-ID');
        }

        // Perbaikan Fungsi Pemicu Edit (Aman dari Masalah String/Angka Laravel)
        function pemicuEdit(idBeli, idPetani, idSayur, harga, jumlah) {
            document.getElementById('formTitle').innerText = 'Edit Form Transaksi Pembelian';
            document.getElementById('btnSimpan').innerText = 'Update';

            document.getElementById('id_petani').value = idPetani;
            updateIdPetani(document.getElementById('id_petani'));

            document.getElementById('id_sayur').value = idSayur;
            updateIdSayur(document.getElementById('id_sayur'));

            document.getElementById('harga_per_kg').value = harga;
            document.getElementById('jumlah_kg').value = jumlah;

            hitungTotal();

            // Siasat Amankan Endpoint Route URL
            const form = document.getElementById('formTransaksiBeli');
            form.action = "{{ url('/transaksibeli') }}/" + idBeli;
            document.getElementById('methodField').innerHTML = `<input type="hidden" name="_method" value="PATCH">`;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetToTambah() {
            document.getElementById('formTitle').innerText = 'Form Transaksi Pembelian';
            document.getElementById('btnSimpan').innerText = 'Simpan';
            document.getElementById('formTransaksiBeli').reset();
            document.getElementById('display_id_petani').value = '-';
            document.getElementById('display_id_sayur').value = '-';
            document.getElementById('display_total_bayar').innerText = 'Rp 0';
            document.getElementById('formTransaksiBeli').action = "{{ route('transaksibeli.store') }}";
            document.getElementById('methodField').innerHTML = '';
        }
    </script>
</x-app-layout>

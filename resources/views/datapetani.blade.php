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
                        <a href="{{ route('transaksibeli') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Transaksi Beli</a>
                        <a href="{{ route('transaksijual') }}" class="flex items-center px-4 py-2.5 text-blue-100 hover:bg-blue-800 hover:bg-opacity-30 rounded-md text-sm transition">Transaksi Jual</a>
                        <a href="{{ route('datapetani') }}" class="flex items-center px-4 py-2.5 bg-blue-900 bg-opacity-40 text-white rounded-md text-sm font-medium">Data Petani</a>
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
                    <h1 class="text-xl font-medium text-gray-900">Data Petani</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Manajemen informasi mitra petani penyuplai sayur</p>
                </div>
            </header>

            @if(session('success'))
                <div class="max-w-4xl mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <section class="max-w-4xl bg-white rounded-lg mb-12">
                <h2 id="formTitle" class="text-sm font-medium text-gray-800 mb-6">Input Data Petani Baru</h2>

                <form id="formPetani" method="POST" action="{{ route('datapetani.store') }}">
                    @csrf
                    <div id="methodField"></div>

                    <div class="grid grid-cols-2 gap-6 text-sm mb-6">
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Id Petani</label>
                            <input type="text" id="id_petani_display" value="Otomatis" disabled class="w-full border-gray-200 rounded-lg p-2.5 bg-gray-100 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Nama Petani</label>
                            <input type="text" id="nama_petani" name="nama_petani" placeholder="Masukkan nama lengkap petani" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">No HP / WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567xxx" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Alamat Rumah</label>
                            <input type="text" id="alamat" name="alamat" placeholder="Contoh: Jl. Raya Ciwidey No. 12" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="resetToTambah()" class="px-5 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                        <button type="submit" id="btnSimpan" class="px-5 py-2 bg-[#0b468c] text-white rounded-lg text-sm font-medium shadow hover:bg-blue-800 transition">Simpan Data</button>
                    </div>
                </form>
            </section>

            <section class="max-w-4xl">
                <h3 class="text-sm font-medium text-gray-800 mb-4">Daftar Kontak Petani</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium w-[15%]">Id Petani</th>
                                <th class="pb-3 font-medium w-[25%]">Nama Petani</th>
                                <th class="pb-3 font-medium w-[20%]">No HP</th>
                                <th class="pb-3 font-medium w-[30%]">Alamat</th>
                                <th class="pb-3 font-medium w-[10%] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($data_petani ?? [] as $petani)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="py-3.5"><span class="px-2 py-0.5 text-xs bg-blue-50 text-blue-600 rounded font-medium">{{ $petani->id_petani }}</span></td>
                                <td class="py-3.5 font-medium">{{ $petani->nama_petani }}</td>
                                <td class="py-3.5 text-gray-600">{{ $petani->no_hp }}</td>
                                <td class="py-3.5 text-gray-500">{{ $petani->alamat }}</td>
                                <td class="py-3.5 flex items-center justify-center space-x-3">
                                    <button type="button" onclick="pemicuEdit('{{ $petani->id_petani }}', '{{ $petani->nama_petani }}', '{{ $petani->no_hp }}', '{{ $petani->alamat }}')" class="text-xs text-blue-600 hover:underline font-medium">Ubah</button>

                                    <form method="POST" action="{{ route('datapetani.destroy', $petani->id_petani) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data petani ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-6 text-gray-400 text-xs">Belum ada data petani di database. Silakan tambahkan melalui form di atas.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        function pemicuEdit(idPetani, namaPetani, noHp, alamat) {
            document.getElementById('formTitle').innerText = 'Edit Data Petani (' + idPetani + ')';
            document.getElementById('btnSimpan').innerText = 'Update Data';
            document.getElementById('id_petani_display').value = idPetani;

            document.getElementById('nama_petani').value = namaPetani;
            document.getElementById('no_hp').value = noHp;
            document.getElementById('alamat').value = alamat;

            const form = document.getElementById('formPetani');
            form.action = '/datapetani/' + idPetani;
            document.getElementById('methodField').innerHTML = `<input type="hidden" name="_method" value="PATCH">`;

            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetToTambah() {
            document.getElementById('formTitle').innerText = 'Input Data Petani Baru';
            document.getElementById('btnSimpan').innerText = 'Simpan Data';
            document.getElementById('id_petani_display').value = 'Otomatis';
            document.getElementById('formPetani').reset();

            document.getElementById('formPetani').action = "{{ route('datapetani.store') }}";
            document.getElementById('methodField').innerHTML = '';
        }
    </script>
</x-app-layout>

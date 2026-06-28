<x-app-layout>
    <div class="flex min-h-screen bg-gray-50 text-gray-800 -mt-6">

        @include('dashboardpemilik.sidebar')

        <main class="flex-1 p-10 bg-white">
            <header class="flex justify-between items-start mb-8">
                <div>
                    <h1 class="text-xl font-medium text-gray-900">Data Petugas</h1>
                    <p class="text-xs text-gray-500 mt-0.5">Manajemen akun aplikasi petugas lapangan</p>
                </div>
            </header>

            @if ($errors->any())
                <div class="max-w-4xl mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="max-w-4xl mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <section class="max-w-4xl bg-white rounded-lg mb-12">
                <h2 id="formTitle" class="text-sm font-medium text-gray-800 mb-6">Input Data Petugas Baru</h2>

                <form id="formPetugas" method="POST" action="{{ route('datapetugas.store') }}">
                    @csrf
                    <div id="methodField"></div>

                    <div class="grid grid-cols-2 gap-6 text-sm mb-6">
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Id Petugas</label>
                            <input type="text" id="id_petugas_display" value="Otomatis" disabled class="w-full border-gray-200 rounded-lg p-2.5 bg-gray-100 text-gray-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Nama Petugas</label>
                            <input type="text" id="nama_petugas" name="nama_petugas" placeholder="Masukkan nama lengkap petugas" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Username</label>
                            <input type="text" id="username" name="username" placeholder="Masukkan username unik" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-gray-600 mb-2 font-medium">Password</label>
                            <input type="password" id="password" name="password" placeholder="Masukkan password akun" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-gray-600 mb-2 font-medium">No HP / WhatsApp</label>
                            <input type="text" id="no_hp" name="no_hp" placeholder="Contoh: 081234567xxx" required class="w-full border-gray-200 rounded-lg p-2.5 focus:border-blue-500">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="resetToTambah()" class="px-5 py-2 text-sm text-gray-600 hover:text-gray-800 font-medium">Batal</button>
                        <button type="submit" id="btnSimpan" class="px-5 py-2 bg-[#0b468c] text-white rounded-lg text-sm font-medium shadow hover:bg-blue-800 transition">Simpan Data</button>
                    </div>
                </form>
            </section>

            <section class="max-w-4xl">
                <h3 class="text-sm font-medium text-gray-800 mb-4">Daftar Akun Petugas</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="text-xs text-gray-400 border-b border-gray-100">
                                <th class="pb-3 font-medium w-[15%]">Id Petugas</th>
                                <th class="pb-3 font-medium w-[25%]">Nama Petugas</th>
                                <th class="pb-3 font-medium w-[20%]">Username</th>
                                <th class="pb-3 font-medium w-[25%]">No HP</th>
                                <th class="pb-3 font-medium w-[15%] text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-700">
                            @forelse($daftar_petugas as $petugas)
                            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition">
                                <td class="py-3.5">
                                    <span class="px-2 py-0.5 text-xs bg-blue-50 text-blue-600 rounded font-medium">
                                        PTG{{ sprintf('%03d', $petugas->id_petugas) }}
                                    </span>
                                </td>
                                <td class="py-3.5 font-medium">{{ $petugas->nama_petugas }}</td>
                                <td class="py-3.5 text-gray-600">{{ $petugas->username }}</td>
                                <td class="py-3.5 text-gray-500">{{ $petugas->no_hp }}</td>
                                <td class="py-3.5 flex items-center justify-center space-x-3">
                                    <button type="button" onclick="pemicuEdit('{{ $petugas->id_petugas }}', '{{ $petugas->nama_petugas }}', '{{ $petugas->username }}', '{{ $petugas->no_hp }}')" class="text-xs text-blue-600 hover:underline font-medium">Ubah</button>

                                    <form method="POST" action="{{ route('datapetugas.destroy', $petugas->id_petugas) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas ini?')">
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
                                <td colspan="5" class="py-6 text-center text-sm text-gray-400">Belum ada data petugas dalam database.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        function pemicuEdit(idPetugas, namaPetugas, username, noHp) {
            document.getElementById('formTitle').innerText = 'Edit Data Petugas (' + idPetugas + ')';
            document.getElementById('btnSimpan').innerText = 'Update Data';
            document.getElementById('id_petugas_display').value = idPetugas;
            document.getElementById('nama_petugas').value = namaPetugas;
            document.getElementById('username').value = username;
            document.getElementById('no_hp').value = noHp;
            document.getElementById('password').value = '';
            document.getElementById('password').placeholder = 'Kosongkan jika tidak ingin mengubah password';
            document.getElementById('password').required = false;

            const form = document.getElementById('formPetugas');
            form.action = "{{ url('/datapetugas') }}/" + idPetugas;
            document.getElementById('methodField').innerHTML = `<input type="hidden" name="_method" value="PATCH">`;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function resetToTambah() {
            document.getElementById('formTitle').innerText = 'Input Data Petugas Baru';
            document.getElementById('btnSimpan').innerText = 'Simpan Data';
            document.getElementById('id_petugas_display').value = 'Otomatis';
            document.getElementById('formPetugas').reset();
            document.getElementById('password').placeholder = 'Masukkan password akun';
            document.getElementById('password').required = true;
            document.getElementById('formPetugas').action = "{{ route('datapetugas.store') }}";
            document.getElementById('methodField').innerHTML = '';
        }
    </script>
</x-app-layout>

<x-app-layout>
    <div class="flex min-h-screen bg-gray-50 text-gray-800 -mt-6">

        @include('dashboardpemilik.sidebar')

        <main class="flex-1 p-10 bg-white" x-data="{ openEditModal: false, selectedSayur: '', selectedStok: 0, selectedIdSayur: 0 }">
            <header class="mb-6">
                <h1 class="text-xl font-medium text-gray-900">Stok Sayuran</h1>
                <p class="text-xs text-gray-400 mt-0.5">Data stok diperbarui otomatis setiap transaksi</p>
            </header>

            @if(session('success'))
                <div class="max-w-5xl mb-6 p-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-xl border border-gray-50 overflow-hidden max-w-5xl mb-6">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-gray-100">
                            <th class="pb-4 font-medium w-[8%]">No</th>
                            <th class="pb-4 font-medium w-[15%]">ID Sayur</th>
                            <th class="pb-4 font-medium w-[25%]">Nama Sayuran</th>
                            <th class="pb-4 font-medium w-[37%]">Jumlah Stok</th>
                            <th class="pb-4 font-medium w-[15%] text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-50">
                        @forelse($data_stok as $index => $stok)
                            @php
                            $kritis = $stok->jumlah_stok < 10;
                            $persen = $stok->jumlah_stok > 0 ? min(100, ($stok->jumlah_stok / max($data_stok->max('jumlah_stok'), 1)) * 100) : 0;
                            @endphp
                            <tr class="align-middle {{ $kritis ? 'bg-red-50/50' : '' }}">
                                <td class="py-4">{{ $index + 1 }}</td>
                                <td class="py-4">
                                    <span class="px-2.5 py-1 text-xs {{ $kritis ? 'bg-red-100 text-red-700' : 'bg-green-50 text-green-700' }} rounded-full font-medium">
                                        S{{ str_pad($stok->id_sayur, 3, '0', STR_PAD_LEFT) }}
                                    </span>
                                </td>
                                <td class="py-4 font-medium {{ $kritis ? 'text-red-700 font-bold' : '' }}">
                                    {{ $stok->nama_sayur }}{{ $kritis ? ' (Kritis)' : '' }}
                                </td>
                                <td class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-24 bg-gray-100 h-2 rounded-full overflow-hidden">
                                            <div class="{{ $kritis ? 'bg-red-600' : 'bg-green-700' }} h-full rounded-full" style="width: {{ $persen }}%"></div>
                                        </div>
                                        <span class="font-medium {{ $kritis ? 'text-red-600 font-bold' : '' }}">{{ $stok->jumlah_stok }} kg</span>
                                    </div>
                                </td>
                                <td class="py-4 text-center">
                                    <button
                                        @click="openEditModal = true; selectedSayur = '{{ $stok->nama_sayur }}'; selectedStok = {{ $stok->jumlah_stok }}; selectedIdSayur = {{ $stok->id_sayur }}"
                                        class="px-3 py-1 {{ $kritis ? 'bg-red-100 text-red-700 hover:bg-red-200' : 'bg-green-50 text-green-700 hover:bg-green-100' }} rounded text-xs font-medium transition">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-10 text-gray-400 italic">Belum ada data stok sayuran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="max-w-5xl text-xs text-gray-500">
                <p>Menampilkan {{ count($data_stok) }} data stok sayuran</p>
            </div>

            <!-- MODAL EDIT -->
            <div x-show="openEditModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40" x-cloak>
                <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-sm" @click.away="openEditModal = false">
                    <h3 class="text-sm font-semibold text-gray-900 mb-1">Sesuaikan Stok Manual</h3>
                    <p class="text-xs text-gray-400 mb-4" x-text="'Sayuran: ' + selectedSayur"></p>
                    <form :action="'/stoksayuran/' + selectedIdSayur" method="POST" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Jumlah Stok (kg)</label>
                            <input type="number" name="jumlah_stok" :value="selectedStok" min="0" class="w-full px-3 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:border-blue-500">
                        </div>
                        <div class="flex justify-end space-x-2 pt-2">
                            <button type="button" @click="openEditModal = false" class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg text-xs hover:bg-gray-50">Batal</button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs hover:bg-blue-700">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>

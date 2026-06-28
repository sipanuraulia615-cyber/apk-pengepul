<x-app-layout>
    <div class="flex min-h-screen bg-gray-50 text-gray-800 -mt-6">

        @include('dashboardpemilik.sidebar')

        <main class="flex-1 p-10 bg-white">
            <header class="mb-8">
                <h1 class="text-xl font-medium text-gray-900">Laporan Transaksi Penjualan</h1>
                <p class="text-xs text-gray-400 mt-0.5">Data penjualan sayuran ke pembeli / agen distributor</p>
            </header>

            <div class="flex items-center space-x-6 text-sm text-gray-700 mb-8">
                <div class="flex items-center space-x-3">
                    <span class="text-gray-500 font-medium">Dari</span>
                    <input type="text" value="{{ date('01/m/Y') }}" class="px-3 py-1.5 bg-gray-50 border border-gray-100 rounded-lg text-sm text-gray-600 focus:outline-none w-28 text-center">
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-500 font-medium">Sampai</span>
                    <input type="text" value="{{ date('d/m/Y') }}" class="px-3 py-1.5 bg-gray-50 border border-gray-100 rounded-lg text-sm text-gray-600 focus:outline-none w-28 text-center">
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-50 overflow-hidden max-w-5xl mb-6">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="text-xs text-gray-400 border-b border-gray-100">
                            <th class="pb-4 font-medium w-[6%]">No</th>
                            <th class="pb-4 font-medium w-[14%]">ID Transaksi</th>
                            <th class="pb-4 font-medium w-[18%]">Sayuran</th>
                            <th class="pb-4 font-medium w-[14%]">Harga Jual/kg</th>
                            <th class="pb-4 font-medium w-[12%]">Jumlah</th>
                            <th class="pb-4 font-medium w-[16%]">Total</th>
                            <th class="pb-4 font-medium w-[10%]">Waktu</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 divide-y divide-gray-50">
                        @forelse($laporan_jual as $index => $data)
                        <tr class="align-middle">
                            <td class="py-4">{{ $index + 1 }}</td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 text-xs bg-green-50 text-green-700 rounded-full font-medium">
                                    JAL{{ str_pad($data->id_jual, 3, '0', STR_PAD_LEFT) }}
                                </span>
                            </td>
                            <td class="py-4 font-medium">{{ $data->nama_sayur }}</td>
                            <td class="py-4">Rp {{ number_format($data->harga_per_kg, 0, ',', '.') }}</td>
                            <td class="py-4">{{ $data->jumlah_kg }} kg</td>
                            <td class="py-4 font-medium">Rp {{ number_format($data->total_bayar, 0, ',', '.') }}</td>
                            <td class="py-4 text-xs text-gray-500">{{ date('d/m H:i', strtotime($data->waktu_jual)) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-10 text-gray-400 italic">
                                Belum ada data transaksi penjualan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="max-w-5xl flex justify-between items-center text-xs text-gray-500">
                <p>Menampilkan {{ count($laporan_jual) }} data transaksi penjualan</p>
                <div class="flex items-center space-x-2">
                    <button class="w-7 h-7 bg-[#0d47a1] text-white flex items-center justify-center rounded font-medium shadow-sm">1</button>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>

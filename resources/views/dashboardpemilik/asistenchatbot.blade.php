<x-app-layout>
    <div class="flex h-screen bg-gray-50 text-gray-800 -mt-6 overflow-hidden">

        @include('dashboardpemilik.sidebar')

        <main class="flex-1 flex flex-col bg-white">
            <header class="p-6 border-b border-gray-100 flex justify-between items-center bg-white shrink-0">
                <div>
                    <h1 class="text-lg font-semibold text-gray-900 flex items-center space-x-2">
                        <span class="w-2.5 h-2.5 bg-green-500 rounded-full inline-block animate-pulse"></span>
                        <span>Asisten AI Lancar Jaya</span>
                    </h1>
                    <p class="text-xs text-gray-400 mt-0.5">Tanyakan tren penjualan, sisa stok sayur, atau laporan transaksi.</p>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="togglePanduan()" class="flex items-center space-x-2 px-4 py-2 text-xs text-blue-600 hover:text-blue-800 border border-blue-200 hover:border-blue-400 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Panduan</span>
                    </button>
                    <button onclick="bersihkanChat()" class="flex items-center space-x-2 px-4 py-2 text-xs text-gray-500 hover:text-red-500 border border-gray-200 hover:border-red-300 rounded-lg transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <span>Bersihkan Chat</span>
                    </button>
                </div>
            </header>

            {{-- TABEL PANDUAN --}}
            <div id="tabelPanduan" class="hidden border-b border-gray-100 bg-blue-50/50 p-6 shrink-0 overflow-y-auto max-h-72">
                <h2 class="text-sm font-semibold text-gray-800 mb-3">📋 Daftar Pertanyaan yang Bisa Digunakan</h2>
                <table class="w-full text-xs border-collapse">
                    <thead>
                        <tr class="text-gray-500 border-b border-gray-200">
                            <th class="pb-2 text-left font-medium w-1/4">Kategori</th>
                            <th class="pb-2 text-left font-medium w-2/4">Contoh Pertanyaan</th>
                            <th class="pb-2 text-left font-medium w-1/4">Kata Kunci</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr class="border-b border-gray-100">
                            <td class="py-2 font-medium text-blue-700">📦 Stok Sayuran</td>
                            <td class="py-2">
                                <div>"Tampilkan semua stok sayuran"</div>
                                <div class="text-gray-400">"Stok wortel berapa?"</div>
                                <div class="text-gray-400">"Sayuran apa yang stoknya paling sedikit?"</div>
                            </td>
                            <td class="py-2 text-gray-500">stok, sisa, persediaan, sedikit, kritis</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 font-medium text-green-700">📈 Laporan Jual</td>
                            <td class="py-2">
                                <div>"Laporan jual bulan juni"</div>
                                <div class="text-gray-400">"Penjualan bulan april sampai mei"</div>
                                <div class="text-gray-400">"Laporan jual hari ini"</div>
                            </td>
                            <td class="py-2 text-gray-500">jual, penjualan, laporan jual</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 font-medium text-blue-700">🛒 Laporan Beli</td>
                            <td class="py-2">
                                <div>"Laporan beli bulan juni"</div>
                                <div class="text-gray-400">"Pembelian minggu ini"</div>
                                <div class="text-gray-400">"Laporan beli hari ini"</div>
                            </td>
                            <td class="py-2 text-gray-500">beli, pembelian, laporan beli</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 font-medium text-purple-700">⚖️ Perbandingan</td>
                            <td class="py-2">
                                <div>"Perbandingan beli vs jual bulan juni"</div>
                                <div class="text-gray-400">"Untung rugi bulan ini"</div>
                                <div class="text-gray-400">"Beli vs jual minggu ini"</div>
                            </td>
                            <td class="py-2 text-gray-500">perbandingan, vs, banding, untung, rugi</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 font-medium text-orange-700">👨‍🌾 Transaksi Petani</td>
                            <td class="py-2">
                                <div>"Transaksi dari petani Budi"</div>
                                <div class="text-gray-400">"Pembelian dari petani Amel"</div>
                            </td>
                            <td class="py-2 text-gray-500">petani, transaksi dari, pembelian dari</td>
                        </tr>
                        <tr>
                            <td class="py-2 font-medium text-gray-700">💰 Total Omzet</td>
                            <td class="py-2">
                                <div>"Total penjualan bulan juni"</div>
                                <div class="text-gray-400">"Omzet bulan ini"</div>
                            </td>
                            <td class="py-2 text-gray-500">total penjualan, total jual, omzet</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex-1 overflow-y-auto p-8 space-y-6 bg-gray-50/50" id="chatArea">
                <div class="flex items-start space-x-3 max-w-3xl">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 text-[#0d47a1] flex items-center justify-center font-bold text-xs shrink-0">AI</div>
                    <div class="bg-white p-4 rounded-xl rounded-tl-none border border-gray-100 shadow-sm text-sm leading-relaxed">
                        <p class="font-medium text-gray-900 mb-1">Halo! 👋</p>
                        Saya asisten cerdas PD. Lancar Jaya. Saya terhubung langsung ke database stok dan laporan transaksi. Ada yang bisa saya bantu?
                        <div class="mt-4 grid grid-cols-2 gap-2 text-xs text-blue-700">
                            <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">📊 Laporan jual bulan juni</button>
                            <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">🥬 Sayuran apa yang stoknya paling sedikit?</button>
                            <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">🛒 Tampilkan semua stok sayuran</button>
                            <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">📈 Perbandingan beli vs jual bulan juni</button>
                        </div>
                    </div>
                </div>
            </div>

            <footer class="p-6 border-t border-gray-100 bg-white shrink-0">
                <form id="formChat" class="max-w-4xl mx-auto flex items-center space-x-3">
                    @csrf
                    <div class="flex-1 relative">
                        <input type="text" id="inputChat" placeholder="Tanyakan sesuatu, contoh: laporan jual bulan juni..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm placeholder-gray-400 focus:outline-none focus:bg-white focus:border-blue-500 transition">
                    </div>
                    <button type="submit" class="px-5 py-3 bg-[#0d47a1] hover:bg-blue-800 text-white rounded-xl text-sm font-medium shadow transition flex items-center space-x-2">
                        <span>Kirim</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </footer>
        </main>
    </div>

    <script>
        const chatArea = document.getElementById('chatArea');
        const inputChat = document.getElementById('inputChat');
        const formChat  = document.getElementById('formChat');
        const csrf      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function togglePanduan() {
            const panel = document.getElementById('tabelPanduan');
            panel.classList.toggle('hidden');
        }

        const pesanAwal = `
            <div class="flex items-start space-x-3 max-w-3xl">
                <div class="w-8 h-8 rounded-lg bg-blue-100 text-[#0d47a1] flex items-center justify-center font-bold text-xs shrink-0">AI</div>
                <div class="bg-white p-4 rounded-xl rounded-tl-none border border-gray-100 shadow-sm text-sm leading-relaxed">
                    <p class="font-medium text-gray-900 mb-1">Halo! 👋</p>
                    Saya asisten cerdas PD. Lancar Jaya. Saya terhubung langsung ke database stok dan laporan transaksi. Ada yang bisa saya bantu?
                    <div class="mt-4 grid grid-cols-2 gap-2 text-xs text-blue-700">
                        <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">📊 Laporan jual bulan juni</button>
                        <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">🥬 Sayuran apa yang stoknya paling sedikit?</button>
                        <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">🛒 Tampilkan semua stok sayuran</button>
                        <button onclick="kirimContoh(this)" class="p-2 bg-blue-50 hover:bg-blue-100 text-left rounded-lg border border-blue-100 font-medium transition">📈 Perbandingan beli vs jual bulan juni</button>
                    </div>
                </div>
            </div>`;

        function bersihkanChat() {
            if (!confirm('Bersihkan seluruh riwayat chat?')) return;
            chatArea.innerHTML = pesanAwal;
        }

        function kirimContoh(btn) {
            inputChat.value = btn.innerText.replace(/^[^\w]+/, '').trim();
            formChat.dispatchEvent(new Event('submit'));
        }

        function tambahPesan(teks, darisiapa) {
            const isAI = darisiapa === 'ai';
            const wrap = document.createElement('div');
            wrap.className = `flex items-start space-x-3 max-w-3xl ${isAI ? '' : 'ml-auto justify-end'}`;
            wrap.innerHTML = isAI
                ? `<div class="w-8 h-8 rounded-lg bg-blue-100 text-[#0d47a1] flex items-center justify-center font-bold text-xs shrink-0">AI</div>
                   <div class="bg-white p-4 rounded-xl rounded-tl-none border border-gray-100 shadow-sm text-sm leading-relaxed w-full">${teks}</div>`
                : `<div class="bg-[#0d47a1] text-white p-4 rounded-xl rounded-tr-none shadow-sm text-sm max-w-xl">${teks}</div>
                   <div class="w-8 h-8 rounded-full bg-blue-200 text-[#0d47a1] flex items-center justify-center font-bold text-xs shrink-0">P</div>`;
            chatArea.appendChild(wrap);
            chatArea.scrollTop = chatArea.scrollHeight;
        }

        function renderHasil(hasil) {
            const fmt   = n => 'Rp ' + Number(n).toLocaleString('id-ID');
            const fmtKg = n => Number(n).toLocaleString('id-ID') + ' kg';

            if (hasil.tipe === 'teks') {
                return `<p>${hasil.pesan}</p>`;
            }

            if (hasil.tipe === 'stok' || hasil.tipe === 'stok_sedikit') {
                let html = `<p class="mb-3 font-medium">${hasil.pesan}</p>
                <table class="w-full text-left border-collapse bg-gray-50 rounded-lg overflow-hidden text-xs">
                    <thead><tr class="text-gray-400 border-b border-gray-200">
                        <th class="p-2">Sayuran</th><th class="p-2">Stok</th>
                    </tr></thead><tbody>`;
                hasil.data.forEach(r => {
                    const kritis = r.jumlah_stok < 10;
                    html += `<tr class="border-b border-gray-100">
                        <td class="p-2 font-medium ${kritis ? 'text-red-600' : ''}">${r.nama_sayur}</td>
                        <td class="p-2 ${kritis ? 'text-red-600 font-bold' : ''}">${fmtKg(r.jumlah_stok)}</td>
                    </tr>`;
                });
                html += '</tbody></table>';
                return html;
            }

            if (hasil.tipe === 'laporan_jual') {
                let html = `<p class="mb-3 font-medium">${hasil.pesan}</p>
                <table class="w-full text-left border-collapse bg-gray-50 rounded-lg overflow-hidden text-xs">
                    <thead><tr class="text-gray-400 border-b border-gray-200">
                        <th class="p-2">ID</th><th class="p-2">Sayuran</th>
                        <th class="p-2">Harga/kg</th><th class="p-2">Jumlah</th>
                        <th class="p-2">Total</th><th class="p-2">Waktu</th>
                    </tr></thead><tbody>`;
                hasil.data.forEach(r => {
                    html += `<tr class="border-b border-gray-100">
                        <td class="p-2"><span class="px-1.5 py-0.5 bg-green-50 text-green-700 rounded font-mono">JAL${String(r.id_jual).padStart(3,'0')}</span></td>
                        <td class="p-2 font-medium">${r.nama_sayur}</td>
                        <td class="p-2">${fmt(r.harga_per_kg)}</td>
                        <td class="p-2">${fmtKg(r.jumlah_kg)}</td>
                        <td class="p-2 font-semibold">${fmt(r.total_bayar)}</td>
                        <td class="p-2 text-gray-400">${r.waktu_jual ? r.waktu_jual.substring(5,16).replace('T',' ') : '-'}</td>
                    </tr>`;
                });
                html += `</tbody>
                <tfoot><tr class="bg-green-50 font-bold text-green-800 border-t border-green-200">
                    <td colspan="3" class="p-2">TOTAL</td>
                    <td class="p-2">${fmtKg(hasil.total_kg)}</td>
                    <td class="p-2">${fmt(hasil.total_bayar)}</td>
                    <td></td>
                </tr></tfoot></table>`;
                return html;
            }

            if (hasil.tipe === 'laporan_beli') {
                let html = `<p class="mb-3 font-medium">${hasil.pesan}</p>
                <table class="w-full text-left border-collapse bg-gray-50 rounded-lg overflow-hidden text-xs">
                    <thead><tr class="text-gray-400 border-b border-gray-200">
                        <th class="p-2">ID</th><th class="p-2">Petani</th><th class="p-2">Sayuran</th>
                        <th class="p-2">Harga/kg</th><th class="p-2">Jumlah</th>
                        <th class="p-2">Total</th><th class="p-2">Waktu</th>
                    </tr></thead><tbody>`;
                hasil.data.forEach(r => {
                    html += `<tr class="border-b border-gray-100">
                        <td class="p-2"><span class="px-1.5 py-0.5 bg-blue-50 text-blue-700 rounded font-mono">BEL${String(r.id_beli).padStart(3,'0')}</span></td>
                        <td class="p-2 font-medium">${r.nama_petani}</td>
                        <td class="p-2">${r.nama_sayur}</td>
                        <td class="p-2">${fmt(r.harga_per_kg)}</td>
                        <td class="p-2">${fmtKg(r.jumlah_kg)}</td>
                        <td class="p-2 font-semibold">${fmt(r.total_bayar)}</td>
                        <td class="p-2 text-gray-400">${r.waktu_beli ? r.waktu_beli.substring(5,16).replace('T',' ') : '-'}</td>
                    </tr>`;
                });
                html += `</tbody>
                <tfoot><tr class="bg-blue-50 font-bold text-blue-800 border-t border-blue-200">
                    <td colspan="4" class="p-2">TOTAL</td>
                    <td class="p-2">${fmtKg(hasil.total_kg)}</td>
                    <td class="p-2">${fmt(hasil.total_bayar)}</td>
                    <td></td>
                </tr></tfoot></table>`;
                return html;
            }

            if (hasil.tipe === 'perbandingan') {
                const selisih = hasil.selisih;
                const isUntung = hasil.status === 'untung';
                const warnaBadge = isUntung ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                const labelStatus = isUntung ? '✅ Estimasi UNTUNG' : '⚠️ Estimasi RUGI';

                let html = `<p class="mb-3 font-medium">${hasil.pesan}</p>`;

                // Tabel Ringkasan
                html += `<table class="w-full text-left border-collapse bg-gray-50 rounded-lg overflow-hidden text-xs mb-4">
                    <thead><tr class="text-gray-400 border-b border-gray-200">
                        <th class="p-2">Jenis</th><th class="p-2">Total (kg)</th><th class="p-2">Total (Rp)</th>
                    </tr></thead>
                    <tbody>
                        <tr class="border-b border-gray-100">
                            <td class="p-2 font-medium text-blue-700">🛒 Pembelian</td>
                            <td class="p-2">${fmtKg(hasil.kg_beli)}</td>
                            <td class="p-2 font-semibold">${fmt(hasil.total_beli)}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="p-2 font-medium text-green-700">📈 Penjualan</td>
                            <td class="p-2">${fmtKg(hasil.kg_jual)}</td>
                            <td class="p-2 font-semibold">${fmt(hasil.total_jual)}</td>
                        </tr>
                    </tbody>
                    <tfoot><tr class="${warnaBadge} font-bold border-t border-gray-200">
                        <td colspan="2" class="p-2">${labelStatus}</td>
                        <td class="p-2">${fmt(Math.abs(selisih))}</td>
                    </tr></tfoot>
                </table>`;

                // Tabel Detail Pembelian
                if (hasil.data_beli && hasil.data_beli.length > 0) {
                    html += `<p class="text-xs font-semibold text-blue-700 mb-2 mt-4">Detail Transaksi Pembelian:</p>
                    <table class="w-full text-left border-collapse bg-gray-50 rounded-lg overflow-hidden text-xs mb-4">
                        <thead><tr class="text-gray-400 border-b border-gray-200">
                            <th class="p-2">ID</th><th class="p-2">Petani</th><th class="p-2">Sayuran</th>
                            <th class="p-2">Jumlah</th><th class="p-2">Total</th><th class="p-2">Waktu</th>
                        </tr></thead><tbody>`;
                    hasil.data_beli.forEach(r => {
                        html += `<tr class="border-b border-gray-100">
                            <td class="p-2"><span class="px-1.5 py-0.5 bg-blue-50 text-blue-700 rounded font-mono">BEL${String(r.id_beli).padStart(3,'0')}</span></td>
                            <td class="p-2 font-medium">${r.nama_petani}</td>
                            <td class="p-2">${r.nama_sayur}</td>
                            <td class="p-2">${fmtKg(r.jumlah_kg)}</td>
                            <td class="p-2 font-semibold">${fmt(r.total_bayar)}</td>
                            <td class="p-2 text-gray-400">${r.waktu_beli ? r.waktu_beli.substring(5,16).replace('T',' ') : '-'}</td>
                        </tr>`;
                    });
                    html += `</tbody></table>`;
                } else {
                    html += `<p class="text-xs text-gray-400 mb-4">Tidak ada transaksi pembelian pada periode ini.</p>`;
                }

                // Tabel Detail Penjualan
                if (hasil.data_jual && hasil.data_jual.length > 0) {
                    html += `<p class="text-xs font-semibold text-green-700 mb-2">Detail Transaksi Penjualan:</p>
                    <table class="w-full text-left border-collapse bg-gray-50 rounded-lg overflow-hidden text-xs">
                        <thead><tr class="text-gray-400 border-b border-gray-200">
                            <th class="p-2">ID</th><th class="p-2">Sayuran</th>
                            <th class="p-2">Jumlah</th><th class="p-2">Total</th><th class="p-2">Waktu</th>
                        </tr></thead><tbody>`;
                    hasil.data_jual.forEach(r => {
                        html += `<tr class="border-b border-gray-100">
                            <td class="p-2"><span class="px-1.5 py-0.5 bg-green-50 text-green-700 rounded font-mono">JAL${String(r.id_jual).padStart(3,'0')}</span></td>
                            <td class="p-2 font-medium">${r.nama_sayur}</td>
                            <td class="p-2">${fmtKg(r.jumlah_kg)}</td>
                            <td class="p-2 font-semibold">${fmt(r.total_bayar)}</td>
                            <td class="p-2 text-gray-400">${r.waktu_jual ? r.waktu_jual.substring(5,16).replace('T',' ') : '-'}</td>
                        </tr>`;
                    });
                    html += `</tbody></table>`;
                } else {
                    html += `<p class="text-xs text-gray-400">Tidak ada transaksi penjualan pada periode ini.</p>`;
                }

                return html;
            }

            return `<p>${hasil.pesan ?? 'Tidak ada data.'}</p>`;
        }

        formChat.addEventListener('submit', async function(e) {
            e.preventDefault();
            const teks = inputChat.value.trim();
            if (!teks) return;

            tambahPesan(teks, 'user');
            inputChat.value = '';
            tambahPesan('<span class="text-gray-400 italic text-xs">Sedang menganalisis...</span>', 'ai');

            try {
                const res = await fetch('{{ route("chatbot.proses") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf },
                    body: JSON.stringify({ perintah: teks })
                });

                const json = await res.json();
                const gelembungAI = chatArea.lastElementChild;
                gelembungAI.querySelector('div:last-child').innerHTML = renderHasil(json);
            } catch (err) {
                const gelembungAI = chatArea.lastElementChild;
                gelembungAI.querySelector('div:last-child').innerHTML = '<p class="text-red-500">Terjadi kesalahan. Coba lagi.</p>';
            }

            chatArea.scrollTop = chatArea.scrollHeight;
        });
    </script>
</x-app-layout>

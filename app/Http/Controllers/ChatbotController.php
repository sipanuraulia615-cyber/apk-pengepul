<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatbotController extends Controller
{
    public function proses(Request $request)
    {
        $input = strtolower(trim($request->input('perintah')));
        $hasil = $this->ruleBasedSystem($input);
        return response()->json($hasil);
    }

    private function ruleBasedSystem($input)
    {
        // --- RULE: STOK ---
        if ($this->mengandung($input, ['stok', 'sisa', 'persediaan'])) {
            if ($this->mengandung($input, ['sedikit', 'kritis', 'habis', 'kurang', 'minimum'])) {
                return $this->stokPalingSedikit();
            }
            if ($this->mengandung($input, ['semua', 'seluruh', 'list', 'daftar'])) {
                return $this->semuaStok();
            }
            $namaSayur = $this->ekstrakNamaSayur($input);
            if ($namaSayur) return $this->stokBerdasarkanNama($namaSayur);
            return $this->semuaStok();
        }

        // --- RULE: PERBANDINGAN BELI VS JUAL ---
        if ($this->mengandung($input, ['banding', 'perbandingan', 'vs', 'versus', 'beli vs jual', 'untung', 'rugi'])) {
            $periode = $this->ekstrakPeriode($input);
            return $this->perbandinganBeliJual($periode);
        }

        // --- RULE: LAPORAN JUAL ---
        if ($this->mengandung($input, ['jual', 'penjualan', 'laporan jual'])) {
            $periode = $this->ekstrakPeriode($input);
            return $this->laporanJual($periode);
        }

        // --- RULE: LAPORAN BELI ---
        if ($this->mengandung($input, ['beli', 'pembelian', 'laporan beli'])) {
            $periode = $this->ekstrakPeriode($input);
            return $this->laporanBeli($periode);
        }

        // --- RULE: TRANSAKSI BERDASARKAN PETANI ---
        if ($this->mengandung($input, ['petani', 'transaksi dari', 'pembelian dari'])) {
            $nama = $this->ekstrakNamaOrang($input);
            return $this->transaksiBerdasarkanPetani($nama);
        }

        // --- RULE: TOTAL PENJUALAN ---
        if ($this->mengandung($input, ['total penjualan', 'total jual', 'omzet'])) {
            $periode = $this->ekstrakPeriode($input);
            return $this->totalPenjualan($periode);
        }

        // --- RULE: DATA SAYURAN ---
        if ($this->mengandung($input, ['sayur', 'komoditas', 'produk'])) {
            $namaSayur = $this->ekstrakNamaSayur($input);
            if ($namaSayur) return $this->stokBerdasarkanNama($namaSayur);
            return $this->semuaStok();
        }

        return [
            'tipe'  => 'teks',
            'pesan' => 'Maaf, saya belum memahami perintah tersebut. Coba tanyakan tentang stok, laporan jual, laporan beli, atau perbandingan beli vs jual.',
        ];
    }

    private function sequentialSearch($data, $keyword, $kolom)
    {
        $hasil = [];
        foreach ($data as $item) {
            $nilai = strtolower($item->$kolom ?? '');
            if (str_contains($nilai, strtolower($keyword))) {
                $hasil[] = $item;
            }
        }
        return $hasil;
    }

    private function mengandung($input, $katakunci)
    {
        foreach ($katakunci as $kata) {
            if (str_contains($input, $kata)) return true;
        }
        return false;
    }

    private function ekstrakPeriode($input)
    {
        $bulan = [
            'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
            'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
            'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
        ];

        $tahun = date('Y');
        preg_match('/\b(202\d)\b/', $input, $matchTahun);
        if (!empty($matchTahun)) $tahun = $matchTahun[1];

        // Cek nama bulan spesifik DULU sebelum cek kata "bulan"
        $ditemukan = [];
        foreach ($bulan as $nama => $angka) {
            if (str_contains($input, $nama)) {
                $ditemukan[] = $angka;
            }
        }

        if (count($ditemukan) >= 2) {
            sort($ditemukan);
            return ['tipe' => 'rentang', 'dari' => $ditemukan[0], 'sampai' => $ditemukan[count($ditemukan) - 1], 'tahun' => $tahun];
        }

        if (count($ditemukan) == 1) {
            return ['tipe' => 'bulan', 'bulan' => $ditemukan[0], 'tahun' => $tahun];
        }

        // Baru cek kata umum kalau tidak ada nama bulan spesifik
        if ($this->mengandung($input, ['minggu ini', 'minggu'])) {
            return ['tipe' => 'minggu', 'tahun' => $tahun];
        }
        if ($this->mengandung($input, ['bulan ini'])) {
            return ['tipe' => 'bulan', 'bulan' => date('n'), 'tahun' => $tahun];
        }
        if ($this->mengandung($input, ['hari ini', 'hari', 'terbaru'])) {
            return ['tipe' => 'hari'];
        }

        return ['tipe' => 'semua'];
    }

    private function ekstrakNamaSayur($input)
    {
        $semuaSayur = DB::table('sayur')->get();
        foreach ($semuaSayur as $sayur) {
            if (str_contains($input, strtolower($sayur->nama_sayur))) {
                return $sayur->nama_sayur;
            }
        }
        return null;
    }

    private function ekstrakNamaOrang($input)
    {
        $semuaPetani = DB::table('petani')->get();
        foreach ($semuaPetani as $petani) {
            if (str_contains($input, strtolower($petani->nama_petani))) {
                return $petani->nama_petani;
            }
        }
        return null;
    }

    private function queryPeriode($query, $kolom, $periode)
    {
        if (!$periode) return $query;
        switch ($periode['tipe']) {
            case 'hari':
                return $query->whereDate($kolom, today());
            case 'minggu':
                return $query->whereBetween($kolom, [now()->startOfWeek(), now()->endOfWeek()]);
            case 'bulan':
                return $query->whereMonth($kolom, $periode['bulan'])->whereYear($kolom, $periode['tahun']);
            case 'rentang':
                return $query->whereYear($kolom, $periode['tahun'])
                    ->whereRaw("CAST(strftime('%m', $kolom) AS INTEGER) BETWEEN ? AND ?", [$periode['dari'], $periode['sampai']]);
            default:
                return $query;
        }
    }

    private function stokPalingSedikit()
    {
        $data = DB::table('stok')
            ->join('sayur', 'stok.id_sayur', '=', 'sayur.id_sayur')
            ->select('sayur.nama_sayur', 'stok.jumlah_stok')
            ->orderBy('stok.jumlah_stok', 'asc')
            ->limit(5)
            ->get();

        return ['tipe' => 'stok_sedikit', 'data' => $data, 'pesan' => '5 sayuran dengan stok paling sedikit:'];
    }

    private function semuaStok()
    {
        $data = DB::table('stok')
            ->join('sayur', 'stok.id_sayur', '=', 'sayur.id_sayur')
            ->select('sayur.nama_sayur', 'stok.jumlah_stok')
            ->orderBy('sayur.nama_sayur', 'asc')
            ->get();

        return ['tipe' => 'stok', 'data' => $data, 'pesan' => 'Berikut seluruh data stok sayuran:'];
    }

    private function stokBerdasarkanNama($nama)
    {
        $semuaStok = DB::table('stok')
            ->join('sayur', 'stok.id_sayur', '=', 'sayur.id_sayur')
            ->select('sayur.nama_sayur', 'stok.jumlah_stok')
            ->get();

        $hasil = $this->sequentialSearch($semuaStok, $nama, 'nama_sayur');

        if (empty($hasil)) {
            return ['tipe' => 'teks', 'pesan' => "Data stok untuk \"$nama\" tidak ditemukan."];
        }

        return ['tipe' => 'stok', 'data' => $hasil, 'pesan' => "Hasil pencarian stok untuk \"$nama\":"];
    }

    private function laporanJual($periode)
    {
        $query = DB::table('transaksi_jual')
            ->join('sayur', 'transaksi_jual.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_jual.*', 'sayur.nama_sayur');

        $query = $this->queryPeriode($query, 'transaksi_jual.waktu_jual', $periode);
        $data  = $query->orderBy('transaksi_jual.waktu_jual', 'desc')->get();

        if ($data->isEmpty()) {
            $labelPeriode = $this->labelPeriode($periode);
            return ['tipe' => 'teks', 'pesan' => "Tidak ada transaksi penjualan $labelPeriode."];
        }

        return [
            'tipe'        => 'laporan_jual',
            'data'        => $data,
            'total_bayar' => $data->sum('total_bayar'),
            'total_kg'    => $data->sum('jumlah_kg'),
            'pesan'       => 'Laporan transaksi penjualan:',
        ];
    }

    private function laporanBeli($periode)
    {
        $query = DB::table('transaksi_beli')
            ->join('petani', 'transaksi_beli.id_petani', '=', 'petani.id_petani')
            ->join('sayur', 'transaksi_beli.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_beli.*', 'petani.nama_petani', 'sayur.nama_sayur');

        $query = $this->queryPeriode($query, 'transaksi_beli.waktu_beli', $periode);
        $data  = $query->orderBy('transaksi_beli.waktu_beli', 'desc')->get();

        if ($data->isEmpty()) {
            $labelPeriode = $this->labelPeriode($periode);
            return ['tipe' => 'teks', 'pesan' => "Tidak ada transaksi pembelian $labelPeriode."];
        }

        return [
            'tipe'        => 'laporan_beli',
            'data'        => $data,
            'total_bayar' => $data->sum('total_bayar'),
            'total_kg'    => $data->sum('jumlah_kg'),
            'pesan'       => 'Laporan transaksi pembelian:',
        ];
    }

    private function perbandinganBeliJual($periode)
    {
        $queryBeli = DB::table('transaksi_beli')
            ->join('petani', 'transaksi_beli.id_petani', '=', 'petani.id_petani')
            ->join('sayur', 'transaksi_beli.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_beli.*', 'petani.nama_petani', 'sayur.nama_sayur');
        $queryBeli = $this->queryPeriode($queryBeli, 'transaksi_beli.waktu_beli', $periode);
        $dataBeli  = $queryBeli->orderBy('transaksi_beli.waktu_beli', 'desc')->get();

        $queryJual = DB::table('transaksi_jual')
            ->join('sayur', 'transaksi_jual.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_jual.*', 'sayur.nama_sayur');
        $queryJual = $this->queryPeriode($queryJual, 'transaksi_jual.waktu_jual', $periode);
        $dataJual  = $queryJual->orderBy('transaksi_jual.waktu_jual', 'desc')->get();

        $totalBeli = $dataBeli->sum('total_bayar');
        $totalJual = $dataJual->sum('total_bayar');
        $selisih   = $totalJual - $totalBeli;

        $labelPeriode = $this->labelPeriode($periode);

        return [
            'tipe'          => 'perbandingan',
            'data_beli'     => $dataBeli,
            'data_jual'     => $dataJual,
            'total_beli'    => $totalBeli,
            'total_jual'    => $totalJual,
            'kg_beli'       => $dataBeli->sum('jumlah_kg'),
            'kg_jual'       => $dataJual->sum('jumlah_kg'),
            'selisih'       => $selisih,
            'status'        => $selisih >= 0 ? 'untung' : 'rugi',
            'pesan'         => "Perbandingan beli vs jual $labelPeriode:",
        ];
    }

    private function transaksiBerdasarkanPetani($nama)
    {
        $semuaTransaksi = DB::table('transaksi_beli')
            ->join('petani', 'transaksi_beli.id_petani', '=', 'petani.id_petani')
            ->join('sayur', 'transaksi_beli.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_beli.*', 'petani.nama_petani', 'sayur.nama_sayur')
            ->orderBy('transaksi_beli.waktu_beli', 'desc')
            ->get();

        $hasil = $nama ? $this->sequentialSearch($semuaTransaksi, $nama, 'nama_petani') : $semuaTransaksi->toArray();

        if (empty($hasil)) {
            return ['tipe' => 'teks', 'pesan' => "Data transaksi dari petani \"$nama\" tidak ditemukan."];
        }

        return [
            'tipe'        => 'laporan_beli',
            'data'        => $hasil,
            'total_bayar' => collect($hasil)->sum('total_bayar'),
            'total_kg'    => collect($hasil)->sum('jumlah_kg'),
            'pesan'       => "Transaksi dari petani \"$nama\":",
        ];
    }

    private function totalPenjualan($periode)
    {
        $query = DB::table('transaksi_jual');
        $query = $this->queryPeriode($query, 'waktu_jual', $periode);
        $total = $query->sum('total_bayar');
        $kg    = $query->sum('jumlah_kg');

        return [
            'tipe'  => 'teks',
            'pesan' => 'Total penjualan: Rp ' . number_format($total, 0, ',', '.') . ' dari ' . $kg . ' kg.',
        ];
    }

    private function labelPeriode($periode)
    {
        $namaBulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];

        if (!$periode) return '';
        switch ($periode['tipe']) {
            case 'hari':    return 'hari ini';
            case 'minggu':  return 'minggu ini';
            case 'bulan':   return 'bulan ' . ($namaBulan[$periode['bulan']] ?? '') . ' ' . $periode['tahun'];
            case 'rentang': return 'bulan ' . ($namaBulan[$periode['dari']] ?? '') . ' - ' . ($namaBulan[$periode['sampai']] ?? '') . ' ' . $periode['tahun'];
            default:        return 'semua periode';
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiBeliController extends Controller
{
    // 1. MENAMPILKAN HALAMAN & DATA DI TABEL BAWAH FORM (PETUGAS)
    public function index()
    {
        $transaksi_beli = DB::table('transaksi_beli')
            ->join('petani', 'transaksi_beli.id_petani', '=', 'petani.id_petani')
            ->join('sayur', 'transaksi_beli.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_beli.*', 'petani.nama_petani', 'sayur.nama_sayur')
            ->orderBy('transaksi_beli.id_beli', 'desc')
            ->get();

        $data_petani = DB::table('petani')->get();
        $data_sayur  = DB::table('sayur')->get();

        return view('transaksibeli', compact('transaksi_beli', 'data_petani', 'data_sayur'));
    }

    // 2. MENYIMPAN DATA BARU + OTOMATIS UPDATE STOK
    public function store(Request $request)
    {
        $request->validate([
            'id_petani'    => 'required',
            'id_sayur'     => 'required',
            'harga_per_kg' => 'required|numeric',
            'jumlah_kg'    => 'required|numeric',
        ]);

        $total_bayar = $request->harga_per_kg * $request->jumlah_kg;

        DB::table('transaksi_beli')->insert([
            'id_petani'    => $request->id_petani,
            'id_sayur'     => $request->id_sayur,
            'id_petugas'   => Auth::id() ?? 1,
            'harga_per_kg' => $request->harga_per_kg,
            'jumlah_kg'    => $request->jumlah_kg,
            'total_bayar'  => $total_bayar,
            'waktu_beli'   => now(),
        ]);

        $stok = DB::table('stok')->where('id_sayur', $request->id_sayur)->first();
        if ($stok) {
            DB::table('stok')->where('id_sayur', $request->id_sayur)->update([
                'jumlah_stok' => $stok->jumlah_stok + $request->jumlah_kg,
            ]);
        } else {
            DB::table('stok')->insert([
                'id_sayur'    => $request->id_sayur,
                'jumlah_stok' => $request->jumlah_kg,
            ]);
        }

        return redirect()->back()->with('success', 'Transaksi pembelian berhasil disimpan!');
    }

    // 3. UPDATE DATA + OTOMATIS KOREKSI STOK
    public function update(Request $request, $id_beli)
    {
        $request->validate([
            'id_petani'    => 'required',
            'id_sayur'     => 'required',
            'harga_per_kg' => 'required|numeric',
            'jumlah_kg'    => 'required|numeric',
        ]);

        $total_bayar = $request->harga_per_kg * $request->jumlah_kg;
        $lama = DB::table('transaksi_beli')->where('id_beli', $id_beli)->first();

        if ($lama) {
            $stok_lama = DB::table('stok')->where('id_sayur', $lama->id_sayur)->first();
            if ($stok_lama) {
                DB::table('stok')->where('id_sayur', $lama->id_sayur)->update([
                    'jumlah_stok' => max(0, $stok_lama->jumlah_stok - $lama->jumlah_kg),
                ]);
            }
        }

        DB::table('transaksi_beli')->where('id_beli', $id_beli)->update([
            'id_petani'    => $request->id_petani,
            'id_sayur'     => $request->id_sayur,
            'harga_per_kg' => $request->harga_per_kg,
            'jumlah_kg'    => $request->jumlah_kg,
            'total_bayar'  => $total_bayar,
            'waktu_beli'   => now(),
        ]);

        $stok_baru = DB::table('stok')->where('id_sayur', $request->id_sayur)->first();
        if ($stok_baru) {
            DB::table('stok')->where('id_sayur', $request->id_sayur)->update([
                'jumlah_stok' => $stok_baru->jumlah_stok + $request->jumlah_kg,
            ]);
        } else {
            DB::table('stok')->insert([
                'id_sayur'    => $request->id_sayur,
                'jumlah_stok' => $request->jumlah_kg,
            ]);
        }

        return redirect()->back()->with('success', 'Transaksi pembelian berhasil diperbarui!');
    }

    // 4. HAPUS DATA + ROLLBACK STOK
    public function destroy($id_beli)
    {
        $lama = DB::table('transaksi_beli')->where('id_beli', $id_beli)->first();

        if ($lama) {
            $stok = DB::table('stok')->where('id_sayur', $lama->id_sayur)->first();
            if ($stok) {
                DB::table('stok')->where('id_sayur', $lama->id_sayur)->update([
                    'jumlah_stok' => max(0, $stok->jumlah_stok - $lama->jumlah_kg),
                ]);
            }
        }

        DB::table('transaksi_beli')->where('id_beli', $id_beli)->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }

    // 5. LAPORAN BELI (HAK AKSES PEMILIK)
    public function laporanBeliPemilik()
    {
        $laporan_beli = DB::table('transaksi_beli')
            ->join('petani', 'transaksi_beli.id_petani', '=', 'petani.id_petani')
            ->join('sayur', 'transaksi_beli.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_beli.*', 'petani.nama_petani', 'sayur.nama_sayur')
            ->orderBy('transaksi_beli.waktu_beli', 'desc')
            ->get();

        return view('dashboardpemilik.laporanbeli', compact('laporan_beli'));
    }

    // 6. STOK SAYURAN (HAK AKSES PEMILIK)
    public function stokSayurPemilik()
    {
        $data_stok = DB::table('stok')
            ->join('sayur', 'stok.id_sayur', '=', 'sayur.id_sayur')
            ->select('stok.*', 'sayur.nama_sayur')
            ->orderBy('sayur.nama_sayur', 'asc')
            ->get();

        return view('dashboardpemilik.stoksayuran', compact('data_stok'));
    }

    // 7. UPDATE STOK MANUAL (HAK AKSES PEMILIK)
    public function updateStokManual(Request $request, $id_sayur)
    {
        $request->validate([
            'jumlah_stok' => 'required|numeric|min:0',
        ]);

        DB::table('stok')->where('id_sayur', $id_sayur)->update([
            'jumlah_stok' => $request->jumlah_stok,
        ]);

        return redirect()->back()->with('success', 'Stok berhasil diperbarui!');
    }
}

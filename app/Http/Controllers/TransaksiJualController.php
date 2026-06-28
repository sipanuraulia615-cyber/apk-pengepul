<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransaksiJualController extends Controller
{
    public function index()
    {
        $transaksi_jual = DB::table('transaksi_jual')
            ->join('sayur', 'transaksi_jual.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_jual.*', 'sayur.nama_sayur')
            ->orderBy('transaksi_jual.id_jual', 'desc')
            ->get();

        $data_sayur = DB::table('sayur')
            ->leftJoin('stok', 'sayur.id_sayur', '=', 'stok.id_sayur')
            ->select('sayur.*', 'stok.jumlah_stok')
            ->get();

        return view('transaksijual', compact('transaksi_jual', 'data_sayur'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_sayur'     => 'required',
            'harga_per_kg' => 'required|numeric',
            'jumlah_kg'    => 'required|numeric',
        ]);

        $stok = DB::table('stok')->where('id_sayur', $request->id_sayur)->first();
        if (!$stok || $stok->jumlah_stok < $request->jumlah_kg) {
            return redirect()->back()->with('error', 'Stok sayuran tidak mencukupi!');
        }

        $total_bayar = $request->harga_per_kg * $request->jumlah_kg;

        DB::table('transaksi_jual')->insert([
            'id_sayur'     => $request->id_sayur,
            'id_petugas'   => Auth::id() ?? 1,
            'harga_per_kg' => $request->harga_per_kg,
            'jumlah_kg'    => $request->jumlah_kg,
            'total_bayar'  => $total_bayar,
            'waktu_jual'   => now(),
        ]);

        DB::table('stok')->where('id_sayur', $request->id_sayur)->decrement('jumlah_stok', $request->jumlah_kg);

        return redirect()->back()->with('success', 'Transaksi penjualan berhasil disimpan!');
    }

    public function update(Request $request, $id_jual)
    {
        $request->validate([
            'id_sayur'     => 'required',
            'harga_per_kg' => 'required|numeric',
            'jumlah_kg'    => 'required|numeric',
        ]);

        $lama = DB::table('transaksi_jual')->where('id_jual', $id_jual)->first();
        if (!$lama) {
            return redirect()->back()->with('error', 'Data transaksi tidak ditemukan!');
        }

        // Kembalikan stok lama dulu
        DB::table('stok')->where('id_sayur', $lama->id_sayur)->increment('jumlah_stok', $lama->jumlah_kg);

        // Cek stok baru SETELAH rollback
        $stok_baru = DB::table('stok')->where('id_sayur', $request->id_sayur)->first();

        if (!$stok_baru || $stok_baru->jumlah_stok < $request->jumlah_kg) {
            // Batalkan rollback karena gagal
            DB::table('stok')->where('id_sayur', $lama->id_sayur)->decrement('jumlah_stok', $lama->jumlah_kg);
            return redirect()->back()->with('error', 'Stok sayuran tidak mencukupi!');
        }

        $total_bayar = $request->harga_per_kg * $request->jumlah_kg;

        DB::table('transaksi_jual')->where('id_jual', $id_jual)->update([
            'id_sayur'     => $request->id_sayur,
            'harga_per_kg' => $request->harga_per_kg,
            'jumlah_kg'    => $request->jumlah_kg,
            'total_bayar'  => $total_bayar,
            'waktu_jual'   => now(),
        ]);

        DB::table('stok')->where('id_sayur', $request->id_sayur)->decrement('jumlah_stok', $request->jumlah_kg);

        return redirect()->back()->with('success', 'Transaksi penjualan berhasil diperbarui!');
    }

    public function destroy($id_jual)
    {
        $lama = DB::table('transaksi_jual')->where('id_jual', $id_jual)->first();

        if ($lama) {
            $stok = DB::table('stok')->where('id_sayur', $lama->id_sayur)->first();
            if ($stok) {
                DB::table('stok')->where('id_sayur', $lama->id_sayur)->increment('jumlah_stok', $lama->jumlah_kg);
            }
        }

        DB::table('transaksi_jual')->where('id_jual', $id_jual)->delete();

        return redirect()->back()->with('success', 'Transaksi berhasil dihapus!');
    }

    public function laporanJualPemilik()
    {
        $laporan_jual = DB::table('transaksi_jual')
            ->join('sayur', 'transaksi_jual.id_sayur', '=', 'sayur.id_sayur')
            ->select('transaksi_jual.*', 'sayur.nama_sayur')
            ->orderBy('transaksi_jual.waktu_jual', 'desc')
            ->get();

        return view('dashboardpemilik.laporanjual', compact('laporan_jual'));
    }
}
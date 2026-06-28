<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPetugasController extends Controller
{
    public function index()
    {
        // Mengambil data jumlah baris dari database secara dinamis
        $totalPetani = DB::table('petani')->count();
        $totalBeli = DB::table('transaksi_beli')->whereDate('created_at', Carbon::today())->count();
        $totalJual = DB::table('transaksi_jual')->whereDate('created_at', Carbon::today())->count();

        // Mengosongkan riwayat tabel sementara agar tidak eror jika relasi tabel belum siap
        $transaksiTerbaru = [];

        return view('dashboard', compact('totalPetani', 'totalBeli', 'totalJual', 'transaksiTerbaru'));
    }
}

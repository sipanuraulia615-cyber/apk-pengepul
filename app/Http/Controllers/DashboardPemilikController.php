<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        // 1. Total transaksi beli hari ini
        $namaTabelBeli = DB::table('transaksi_beli')->exists() ? 'transaksi_beli' : 'transaksi_beli';
        $totalBeli = DB::table($namaTabelBeli)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // 2. Total transaksi jual hari ini
        $namaTabelJual = DB::table('transaksi_jual')->exists() ? 'transaksi_jual' : 'transaksi_jual';
        $totalJual = DB::table($namaTabelJual)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // 3. Jumlah jenis sayuran
        $namaTabelSayur = DB::table('sayur')->exists() ? 'sayur' : 'sayur';
        $totalSayur = DB::table($namaTabelSayur)->count();

        // 4. Jumlah petugas yang ada di database
        if (DB::table('petugas')->exists()) {
            $totalPetugas = DB::table('petugas')->count();
        } else {
            $totalPetugas = DB::table('users')->where('role', 'petugas')->count();
        }

        // Mengirimkan semua data ke view dashboard pemilik Anda
        return view('dashboardpemilik.dashboardpem', compact('totalBeli', 'totalJual', 'totalSayur', 'totalPetugas'));
    }
}

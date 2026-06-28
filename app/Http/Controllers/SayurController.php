<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SayurController extends Controller
{
    /**
     * Menampilkan halaman master sayur beserta datanya.
     */
    public function index()
    {
        // Mengambil semua data dari tabel sayur
        $data_sayur = DB::table('sayur')->get();

        // Mengirim data ke file blade datasayur
        return view('datasayur', compact('data_sayur'));
    }

    /**
     * Menyimpan data sayur baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input nama_sayur sesuai struktur database Anda
        $request->validate([
            'nama_sayur' => 'required|string|max:255',
        ]);

        // Insert data baru ke tabel sayur
        DB::table('sayur')->insert([
            'nama_sayur' => $request->nama_sayur,
        ]);

        return redirect()->route('datasayur')->with('success', 'Komoditas Sayur baru berhasil ditambahkan!');
    }

    /**
     * Memperbarui data sayur berdasarkan id_sayur.
     */
    public function update(Request $request, $id_sayur)
    {
        $request->validate([
            'nama_sayur' => 'required|string|max:255',
        ]);

        // Update data berdasarkan id_sayur
        DB::table('sayur')
            ->where('id_sayur', $id_sayur)
            ->update([
                'nama_sayur' => $request->nama_sayur,
            ]);

        return redirect()->route('datasayur')->with('success', 'Data Komoditas Sayur berhasil diperbarui!');
    }

    /**
     * Menghapus data sayur berdasarkan id_sayur.
     */
    public function destroy($id_sayur)
    {
        // Hapus data dari tabel sayur
        DB::table('sayur')->where('id_sayur', $id_sayur)->delete();

        return redirect()->route('datasayur')->with('success', 'Komoditas Sayur berhasil dihapus!');
    }
}

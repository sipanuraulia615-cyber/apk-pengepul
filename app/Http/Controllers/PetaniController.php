<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PetaniController extends Controller
{
    /**
     * Menampilkan data master petani.
     */
    public function index()
    {
        // Mengambil semua data petani dari database
        $data_petani = DB::table('petani')->get();

        // Mengembalikan ke view dengan membawa data petani
        return view('datapetani', compact('data_petani'));
    }

    /**
     * Menyimpan data petani baru.
     */
    public function store(Request $request)
    {
        // Validasi input data sesuai kolom database (Sudah diperbaiki ke max:255)
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'no_hp'       => 'required|string|max:255',
            'alamat'      => 'required|string|max:255',
        ]);

        // Insert data ke tabel petani
        DB::table('petani')->insert([
            'nama_petani' => $request->nama_petani,
            'no_hp'       => $request->no_hp,
            'alamat'      => $request->alamat,
        ]);

        return redirect()->back()->with('success', 'Data Petani baru berhasil ditambahkan!');
    }

    /**
     * Memperbarui data petani yang sudah ada.
     */
    public function update(Request $request, $id_petani)
    {
        // Validasi input data (Sudah diperbaiki ke max:255)
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'no_hp'       => 'required|string|max:255',
            'alamat'      => 'required|string|max:255',
        ]);

        // Update data petani berdasarkan id_petani
        DB::table('petani')
            ->where('id_petani', $id_petani)
            ->update([
                'nama_petani' => $request->nama_petani,
                'no_hp'       => $request->no_hp,
                'alamat'      => $request->alamat,
            ]);

        return redirect()->back()->with('success', 'Data Petani berhasil diperbarui!');
    }

    /**
     * Menghapus data petani.
     */
    public function destroy($id_petani)
    {
        // Hapus data petani berdasarkan id_petani
        DB::table('petani')->where('id_petani', $id_petani)->delete();

        return redirect()->back()->with('success', 'Data Petani berhasil dihapus!');
    }
}

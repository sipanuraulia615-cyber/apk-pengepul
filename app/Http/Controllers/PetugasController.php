<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $daftar_petugas = DB::table('petugas')->get();
        return view('dashboardpemilik.datapetugas', compact('daftar_petugas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:petugas,username',
            'password'     => 'required|string|min:4',
            'no_hp'        => 'required|string|max:255',
        ]);

        DB::table('petugas')->insert([
            'nama_petugas' => $request->nama_petugas,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'no_hp'        => $request->no_hp,
        ]);

        return redirect()->back()->with('success', 'Data petugas berhasil disimpan!');
    }

    public function update(Request $request, $id_petugas)
    {
        $request->validate([
            'nama_petugas' => 'required|string|max:255',
            'username'     => 'required|string|max:255|unique:petugas,username,' . $id_petugas . ',id_petugas',
            'no_hp'        => 'required|string|max:255',
        ]);

        $dataUpdate = [
            'nama_petugas' => $request->nama_petugas,
            'username'     => $request->username,
            'no_hp'        => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $dataUpdate['password'] = Hash::make($request->password);
        }

        DB::table('petugas')->where('id_petugas', $id_petugas)->update($dataUpdate);

        return redirect()->back()->with('success', 'Data petugas berhasil diperbarui!');
    }

    public function destroy($id_petugas)
    {
        DB::table('petugas')->where('id_petugas', $id_petugas)->delete();
        return redirect()->back()->with('success', 'Data petugas berhasil dihapus!');
    }
}

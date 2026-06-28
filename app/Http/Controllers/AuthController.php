<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $akses = session('hak_akses');

        if ($akses == 'pemilik') {

            $user = DB::table('pemilik')
                ->where('username', $request->username)
                ->where('password', $request->password)
                ->first();

            if ($user) {

                session([
                    'login' => true,
                    'id_pemilik' => $user->id_pemilik,
                    'nama' => $user->nama_pemilik,
                    'role' => 'pemilik'
                ]);

                return redirect('/dashboardpem');
            }
        }

        if ($akses == 'petugas') {

            $user = DB::table('petugas')
                ->where('username', $request->username)
                ->where('password', $request->password)
                ->first();

            if ($user) {

                session([
                    'login' => true,
                    'id_petugas' => $user->id_petugas,
                    'nama' => $user->nama_petugas,
                    'role' => 'petugas'
                ]);

                return redirect('/dashboard');
            }
        }

        return back()->with('error', 'Username atau Password salah');
    }
}
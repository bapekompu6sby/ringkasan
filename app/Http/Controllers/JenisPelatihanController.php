<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JenisPelatihanModel;
use Illuminate\Http\RedirectResponse;

class JenisPelatihanController extends Controller
{
    public function jenisPelatihan()
    {
        $jenis = JenisPelatihanModel::orderBy('id')->get();
        return view('jenis_pelatihan.jenisPelatihan',['jeniss' => $jenis]);
    }
    public function jenisPelatihan_tambah()
    {
        return view('jenis_pelatihan.jenisPelatihan_tambah');
    }
    public function jenisPelatihan_insert(Request $request): RedirectResponse
    {
        if (!$request->validate([
            'nama' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
            ]);
        }

        // Ambil record terakhir dari tabel
        $lastRecord = JenisPelatihanModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 2));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'JP' diikuti oleh angka yang telah diincrement
        $newId = 'JP' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Tambahkan ID yang telah diincrement ke dalam request
        $request->merge(['id' => $newId]);

        // Buat record baru menggunakan metode create
        JenisPelatihanModel::create($request->all());

        return redirect('/kelola-jenis-pelatihan')->with(['success' => 'Data Jenis Pelatihan berhasil ditambahkan', 'popUp_title' => 'Added!']);
    }
    public function jenisPelatihan_edit($id)
    {
        $jenis_pelatihan = JenisPelatihanModel::find($id);
        return view('jenis_pelatihan.jenisPelatihan_edit', ['jenis' => $jenis_pelatihan]);
    }
    public function jenisPelatihan_update(Request $request)
    {
        if (!$request->validate([
            'nama' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
            ]);
        }

        $pelatihan = JenisPelatihanModel::find($request->id);
        $pelatihan->update($request->all());

        return redirect('/kelola-jenis-pelatihan')->with(['success' => 'Data Jenis Pelatihan berhasil diubah', 'popUp_title' => 'Updated!']);
    }
    public function jenisPelatihan_delete($id)
    {
        JenisPelatihanModel::find($id)->delete();

        return redirect('/kelola-jenis-pelatihan')->with(['success' => 'Data Jenis Pelatihan berhasil dihapus', 'popUp_title' => 'Deleted!']);
    }
}
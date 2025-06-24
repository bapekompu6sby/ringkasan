<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ModelPelatihanModel;
use Illuminate\Http\RedirectResponse;

class ModelPelatihanController extends Controller
{
    public function modelPelatihan()
    {
        $model = ModelPelatihanModel::orderBy('id')->get();
        return view('model_pelatihan.modelPelatihan',['models' => $model]);
    }
    public function modelPelatihan_tambah()
    {
        return view('model_pelatihan.modelPelatihan_tambah');
    }
    public function modelPelatihan_insert(Request $request): RedirectResponse
    {
        if (!$request->validate([
            'nama' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
            ]);
        }

        // Ambil record terakhir dari tabel
        $lastRecord = ModelPelatihanModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 2));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'JP' diikuti oleh angka yang telah diincrement
        $newId = 'MP' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Tambahkan ID yang telah diincrement ke dalam request
        $request->merge(['id' => $newId]);

        // Buat record baru menggunakan metode create
        ModelPelatihanModel::create($request->all());

        return redirect('/kelola-model-pelatihan')->with(['success' => 'Data model Pelatihan berhasil ditambahkan', 'popUp_title' => 'Added!']);
    }
    public function modelPelatihan_edit($id)
    {
        $model_pelatihan = ModelPelatihanModel::find($id);
        return view('model_pelatihan.modelPelatihan_edit', ['model' => $model_pelatihan]);
    }
    public function modelPelatihan_update(Request $request)
    {
        if (!$request->validate([
            'nama' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
            ]);
        }

        $pelatihan = ModelPelatihanModel::find($request->id);
        $pelatihan->update($request->all());

        return redirect('/kelola-model-pelatihan')->with(['success' => 'Data Model Pelatihan berhasil diubah', 'popUp_title' => 'Updated!']);
    }
    public function modelPelatihan_delete($id)
    {
        ModelPelatihanModel::find($id)->delete();

        return redirect('/kelola-model-pelatihan')->with(['success' => 'Data Model Pelatihan berhasil dihapus', 'popUp_title' => 'Deleted!']);
    }
}
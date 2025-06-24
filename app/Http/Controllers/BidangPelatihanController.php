<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BidangPelatihanModel;
use Illuminate\Http\RedirectResponse;

class BidangPelatihanController extends Controller
{
    public function bidangPelatihan()
    {
        $bidang = BidangPelatihanModel::orderBy('id')->get();
        return view('bidang_pelatihan.bidangPelatihan',['bidangs' => $bidang]);
    }
    public function bidangPelatihan_tambah()
    {
        return view('bidang_pelatihan.bidangPelatihan_tambah');
    }

    public function bidangPelatihan_insert(Request $request): RedirectResponse
    {
        if (!$request->validate([
            'nama' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
                'gambar',
            ]);
        }

        // Menyimpan gambar ke dalam path yang ditentukan

        $originalName = $request->file('gambar')->getClientOriginalName();
        $timestamp = time(); // Mendapatkan timestamp saat ini
        $newName = $timestamp . '_' . $originalName;

        // Pindahkan file ke dalam direktori dengan nama yang baru
        $gambarPath = $request->file('gambar')->move(public_path('assets/images/bidang_pelatihan'), $newName);

        // Mendapatkan nama file asli
        $fileName = basename($gambarPath);

        // Ambil record terakhir dari tabel
        $lastRecord = BidangPelatihanModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 2));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'BP' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = $request->all();
        $requestData['id'] = $newId;
        $requestData['gambar'] = $fileName; // Simpan nama file gambar ke dalam kolom gambar

        // Buat record baru menggunakan metode create
        BidangPelatihanModel::create($requestData);

        return redirect('/kelola-bidang-pelatihan')->with(['success' => 'Data Bidang Pelatihan berhasil ditambahkan', 'popUp_title' => 'Added!']);
    }
    public function bidangPelatihan_edit($id)
    {
        $bidang_pelatihan = BidangPelatihanModel::find($id);
        return view('bidang_pelatihan.bidangPelatihan_edit', ['bidang' => $bidang_pelatihan]);
    }
    public function bidangPelatihan_update(Request $request)
    {
        if (!$request->validate([
            'nama' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
                'gambar',
            ]);
        }

        $originalName = $request->file('gambar')->getClientOriginalName();
        $timestamp = time(); // Mendapatkan timestamp saat ini
        $newName = $timestamp . '_' . $originalName;

        // Pindahkan file ke dalam direktori dengan nama yang baru
        $gambarPath = $request->file('gambar')->move(public_path('assets/images/bidang_pelatihan'), $newName);

        // Mendapatkan nama file asli
        $fileName = basename($gambarPath);

        $bidang = BidangPelatihanModel::find($request->id);

        $path = public_path('assets/images/bidang_pelatihan/' . $bidang->gambar);
        if (file_exists($path)) {
            unlink($path);
        }

        $bidang->nama = $request->nama;
        $bidang->gambar = $fileName;
        $bidang->save();

        // $bidang->update($requestData);

        return redirect('/kelola-bidang-pelatihan')->with(['success' => 'Data Bidang Pelatihan berhasil diubah', 'popUp_title' => 'Updated!']);
    }
    public function bidangPelatihan_delete($id)
    {
        
        $bidang = BidangPelatihanModel::find($id);

        $path = public_path('assets/images/bidang_pelatihan/' . $bidang->gambar);
        if (file_exists($path)) {
            unlink($path);
        }

        $bidang->delete();

        return redirect('/kelola-bidang-pelatihan')->with(['success' => 'Data Bidang Pelatihan berhasil dihapus', 'popUp_title' => 'Deleted!']);
    }
}
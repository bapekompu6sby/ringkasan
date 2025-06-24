<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetilStatusModel;

class StatusDokumenController extends Controller
{
    public function status_dokumen(Request $request)
    {
        if ($request->has('dokumen_terkirim') || $request->has('pelatihan_terkirim')){
            $dokumen = request('dokumen_terkirim');
            $pelatihan = request('pelatihan_terkirim');

            $terkirim = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
                ->where('keterangan', 'Terkirim')
                ->when($dokumen, function ($query) use ($dokumen) {
                    return $query->whereHas('kegiatan_tahapan', function ($subQuery) use ($dokumen) {
                        $subQuery->where('dokumen', 'like', '%' . $dokumen . '%');
                    });
                })
                ->when($pelatihan, function ($query) use ($pelatihan) {
                    return $query->whereHas('status.pelatihan', function ($subQuery) use ($pelatihan) {
                        $subQuery->where('nama', 'like', '%' . $pelatihan . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();
            
        }
        else{
            $terkirim = DetilStatusModel::with('kegiatan_tahapan', 'status','status.pelatihan')->where('keterangan','Terkirim')->orderBy('created_at','desc')->get();
        }

        if ($request->has('dokumen_disetujui') || $request->has('pelatihan_disetujui')){
            $dokumen = request('dokumen_disetujui');
            $pelatihan = request('pelatihan_disetujui');

            $disetujui = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
                ->where('keterangan', 'Disetujui')
                ->when($dokumen, function ($query) use ($dokumen) {
                    return $query->whereHas('kegiatan_tahapan', function ($subQuery) use ($dokumen) {
                        $subQuery->where('dokumen', 'like', '%' . $dokumen . '%');
                    });
                })
                ->when($pelatihan, function ($query) use ($pelatihan) {
                    return $query->whereHas('status.pelatihan', function ($subQuery) use ($pelatihan) {
                        $subQuery->where('nama', 'like', '%' . $pelatihan . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }
        else{
            $disetujui = DetilStatusModel::with('kegiatan_tahapan', 'status','status.pelatihan')->where('keterangan','Disetujui')->orderBy('created_at','desc')->get();
        }

        if ($request->has('dokumen_ditolak') || $request->has('pelatihan_ditolak')){
            $dokumen = request('dokumen_ditolak');
            $pelatihan = request('pelatihan_ditolak');

            $ditolak = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
                ->where('keterangan', 'Ditolak')
                ->when($dokumen, function ($query) use ($dokumen) {
                    return $query->whereHas('kegiatan_tahapan', function ($subQuery) use ($dokumen) {
                        $subQuery->where('dokumen', 'like', '%' . $dokumen . '%');
                    });
                })
                ->when($pelatihan, function ($query) use ($pelatihan) {
                    return $query->whereHas('status.pelatihan', function ($subQuery) use ($pelatihan) {
                        $subQuery->where('nama', 'like', '%' . $pelatihan . '%');
                    });
                })
                ->orderBy('created_at', 'desc')
                ->get();
        }
        else{
            $ditolak = DetilStatusModel::with('kegiatan_tahapan', 'status','status.pelatihan')->where('keterangan','Ditolak')->orderBy('created_at','desc')->get();
        }

        // dd($terkirim[0]->file);
        return view('dokumen.statusDokumen', ['terkirims' => $terkirim, 'disetujuis' => $disetujui, 'ditolaks' => $ditolak ]);
    }
}
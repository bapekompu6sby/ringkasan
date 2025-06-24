<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetilStatusModel;

class TinjauDokumenController extends Controller
{
    public function tinjau_dokumen(Request $request)
    {
        if ($request->has('dokumen_belum') || $request->has('pelatihan_belum')){
            $dokumen = request(' dokumen_belum');
            $pelatihan = request('pelatihan_belum');

            $belum = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
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
            $belum = DetilStatusModel::with('kegiatan_tahapan', 'status','status.pelatihan')->where('keterangan','Terkirim')->orderBy('created_at','desc')->get();
        }

        if($request->has('dokumen_telah') || $request->has('pelatihan_telah')){
            $dokumen = request('dokumen_telah');
            $pelatihan = request('pelatihan_telah');

            $telah = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
            ->where(function ($query) {
                $query->where('keterangan', 'Disetujui')
                    ->orWhere('keterangan', 'Ditolak');
            })
            ->whereHas('kegiatan_tahapan', function ($subQuery) use ($dokumen) {
                if ($dokumen) {
                    $subQuery->where('dokumen', 'like', '%' . $dokumen . '%');
                }
            })
            ->whereHas('status.pelatihan', function ($subQuery) use ($pelatihan) {
                if ($pelatihan) {
                    $subQuery->where('nama', 'like', '%' . $pelatihan . '%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }
        else{
            $telah = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
            ->where(function ($query) {
                $query->where('keterangan', 'Disetujui')
                    ->orWhere('keterangan', 'Ditolak');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }

        // dd($terkirim[0]->file);
        return view('dokumen.tinjauDokumen', ['belums' => $belum, 'telahs' => $telah]);
    }

    public function setujui_dokumen($id_fl)
    {
        $status = DetilStatusModel::find($id_fl);
        $status->keterangan = 'Disetujui';
        $status->save();

        return redirect()->back();
    }
    public function tolak_dokumen($id_fl, Request $request)
    {
        $status = DetilStatusModel::find($id_fl);
        $status->keterangan = 'Ditolak';
        $status->komentar = $request->pesan;
        $status->save();

        return redirect()->back();
    }
    
    public function unduh_dokumen($id_fl)
    {
        $status = DetilStatusModel::find($id_fl);
        $file = $status->file;
        return response()->download(public_path('assets/dokumen/' . $file));
    }
}
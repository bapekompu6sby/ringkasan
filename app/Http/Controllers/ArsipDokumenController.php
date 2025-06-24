<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use App\Models\TahapanModel;
use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\DetilStatusModel;
use Illuminate\Support\Facades\DB;
use App\Models\BidangPelatihanModel;
use App\Models\KegiatantahapanModel;

class ArsipDokumenController extends Controller
{
    public function arsip_dokumen(Request $request)
    {
        if ($request->has('querypelatihan') && $request->has('queryperiode')) {
            $querypelatihan = request('querypelatihan');
            $queryperiode = request('queryperiode');

            $dokumens = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
                ->whereHas('status.pelatihan', function ($query) use ($querypelatihan, $queryperiode) {
                    $query->where('keterangan', 'Disetujui');
                    if ($querypelatihan) {
                        $query->where('nama', 'like', '%' . $querypelatihan . '%');
                    }
                    if ($queryperiode) {
                        $query->where('tahun_periode', '=', $queryperiode);
                    }
                })->orderBy('created_at','desc')->get()->groupBy('status.pelatihan.id');

        } else {
            $dokumens = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')->where('keterangan','Disetujui')->orderBy('created_at','desc')->get()->groupBy('status.pelatihan.id');
        }

        // dd($dokumens);

        return view('dokumen.arsipDokumen', ['dokumens' => $dokumens,'querypelatihan'=> request('querypelatihan'),'queryperiode'=> request('queryperiode')]);
    }
    public function arsip_dokumen_pelatihan($id_pl,Request $request)
    {
        $status = StatusModel::where('id_pelatihan', $id_pl)->first();

        if ($request->has('nama_dokumen')){
            $namaDokumen = request('nama_dokumen');

            $dokumens = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')
                ->whereHas('kegiatan_tahapan', function ($query) use ($namaDokumen) {
                    $query->where('keterangan', 'Disetujui');
                    if ($namaDokumen) {
                        $query->where('dokumen', 'like', '%' . $namaDokumen . '%');
                    }
                })->where('id_status',$status->id)->orderBy('created_at','desc')->get()->groupBy('status.pelatihan.id');
        }
        else{
            $dokumens = DetilStatusModel::with('kegiatan_tahapan', 'status', 'status.pelatihan')->where('keterangan','Disetujui')->where('id_status',$status->id)->orderBy('created_at','desc')->get()->groupBy('status.pelatihan.id');
        }
        // dd($dokumens);

        // foreach ($dokumens[$id_pl] as $dokumen) {
        //     dd($dokumen->file);
        // }

        // dd($dokumens[$id_pl]->file);

        return view('dokumen.arsipDokumen_pelatihan', ['dokumens' => $dokumens,'nama_dokumen'=> request('nama_dokumen'),'id_pelatihan' => $id_pl]);
    }

    public function unduh_dokumen($id_fl)
    {
        $status = DetilStatusModel::find($id_fl);
        $file = $status->file;
        return response()->download(public_path('assets/dokumen/' . $file));
    }

}
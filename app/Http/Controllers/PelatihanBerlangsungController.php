<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use App\Models\TahapanModel;
use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\DetilStatusModel;
use App\Models\BidangPelatihanModel;
use App\Models\KegiatanTahapanModel;

class PelatihanBerlangsungController extends Controller
{
    public function pelatihan_berlangsung(Request $request)
    {
        if ($request->has('querypelatihan')) {
            $pelatihans = PelatihanModel::with('jenis_pelatihan', 'bidang_pelatihan', 'model_pelatihan')
            ->whereHas('status', function ($query) {
                $query->where('ket_status', 'Sedang berlangsung')->where('nama', 'like', '%' . request('querypelatihan') . '%');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        } else {
            $pelatihans = PelatihanModel::with('jenis_pelatihan', 'bidang_pelatihan', 'model_pelatihan')
            ->whereHas('status', function ($query) {
                $query->where('ket_status', 'Sedang berlangsung');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        }

        // $status_terakhir = DetilStatusModel::whereIn('id_status', function ($query) {
        //     $query->select(DB::raw('MAX(id_status)'))
        //         ->from('detil_status')
        //         ->groupBy('id_status');
        // })
        // ->leftJoin('status', 'detil_status.id_status', '=', 'status.id')
        // ->leftJoin('kegiatan_tahapan', 'detil_status.id_kegiatan_tahapan', '=', 'kegiatan_tahapan.id')
        // ->whereIn('status.id_pelatihan', $pelatihans->pluck('id'))
        // ->select('detil_status.id_kegiatan_tahapan', 'status.id_pelatihan') 
        // ->get()
        // ->keyBy('id_pelatihan')
        // ->map(function ($item) {
        //     return $item->nama;
        // });


        $tahapans = TahapanModel::all();
        $pelatihan_progres = [];
        foreach($pelatihans as $pelatihan){
            $status = StatusModel::where('id_pelatihan', $pelatihan->id)->first();
            $detil_status = DetilStatusModel::with('kegiatan_tahapan')->where('id_status', $status->id)->where('keterangan', 'Disetujui')->get();

            $count_per_tahapan = [];
            foreach ($tahapans as $tahapan){
                $count_per_tahapan[$tahapan->id] = 0;
            }
            foreach ($detil_status as $detil){
                // dd($detil);
                $count_per_tahapan[$detil->kegiatan_tahapan->id_tahapan]++;
            }
            $status_per_tahapan = [];
            foreach ($count_per_tahapan as $tahapan => $count) {
                $kegiatanCount = KegiatanTahapanModel::where('id_tahapan', $tahapan)->count();
            
                if ($count == $kegiatanCount)
                    $status_per_tahapan[$tahapan] = 'yes';
                else if ($count == 0)
                    $status_per_tahapan[$tahapan] = 'no';
                else
                    $status_per_tahapan[$tahapan] = 'process';
            }
            $pelatihan_progres[$pelatihan->id] = $status_per_tahapan;
        }

        // dd($pelatihan_progres);

        $tahapanKegiatan = KegiatanTahapanModel::with('tahapan')->get()->groupBy('id_tahapan');


        $bidang_pelatihan = BidangPelatihanModel::all();

        return view('pelatihan.pelatihanBerlangsung', ['pelatihans' => $pelatihans, 'pelatihan_progres'=>$pelatihan_progres,'tahapanKegiatan'=>$tahapanKegiatan,'bidangs'=>$bidang_pelatihan,'tahapans'=>$tahapans, 'querypelatihan'=> request('querypelatihan')]);
    }

    public function pelatihan_arsip($id){
        $status = StatusModel::where('id_pelatihan', $id)->first();
        $status->ket_status = 'Selesai';
        $status->save();

        return redirect('/pelatihan-berlangsung')->with(['success' => 'Status pelatihan selesai', 'popUp_title' => 'Updated!']);
    }
    public function pelatihan_delete($id){
        $status = StatusModel::where('id_pelatihan', $id)->first();
        DetilStatusModel::where('id_status', $status->id)->delete();
        StatusModel::where('id_pelatihan', $id)->delete();
        PelatihanModel::find($id)->delete();

        return redirect('/pelatihan-berlangsung')->with(['success' => 'Pelatihan berhasil dihapus', 'popUp_title' => 'Deleted!']);
    }

    public function progress_pelatihan($id)
    {
        $status = StatusModel::where('id_pelatihan', $id)->first();
        $detil_status = DetilStatusModel::where('id_status', $status->id)->get();
        $tahapanKegiatan = KegiatanTahapanModel::with('tahapan')->get()->groupBy('id_tahapan');
        $pelatihan = PelatihanModel::find($id);
        
        return view('pelatihan.pelatihanProgres_cetak', [
            'tahapan_kegiatans' => $tahapanKegiatan,
            'detil_status' => $detil_status,
        ]);
    }


    public function menu_dokumen_pelatihan($id_pl,$no_thp,$id_thp)
    {
        // dd($id_pl,$no_thp,$id_thp);
        $pelatihan = PelatihanModel::with('status')->find($id_pl);
        $status = StatusModel::where('id_pelatihan', $id_pl)->first();
        $tahapan = TahapanModel::find($id_thp);
        $kegiatan_tahapan = KegiatanTahapanModel::where('id_tahapan', $tahapan->id)->get();
        $badge_tahapan = DetilStatusModel::where('id_status', $status->id);
        $badge = $badge_tahapan->pluck('id_kegiatan_tahapan');

        return view('dokumen.menu_dokumen_pelatihan' ,[
            'pelatihan' => $pelatihan,
            'tahapan' => $tahapan,
            'kegiatanTahapan' => $kegiatan_tahapan,
            'badge' => $badge,
            'noTHP' => $no_thp
       ]);
    }


    public function pelatihan_slides()
    {
        $pelatihans = PelatihanModel::with('jenis_pelatihan', 'bidang_pelatihan', 'model_pelatihan')
            ->whereHas('status', function ($query) {
                $query->where('ket_status', 'Sedang berlangsung');
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $tahapans = TahapanModel::all();
        $pelatihan_progres = [];
        foreach($pelatihans as $pelatihan){
            $status = StatusModel::where('id_pelatihan', $pelatihan->id)->first();
            $detil_status = DetilStatusModel::with('kegiatan_tahapan')->where('id_status', $status->id)->where('keterangan', 'Disetujui')->get();

            $count_per_tahapan = [];
            foreach ($tahapans as $tahapan){
                $count_per_tahapan[$tahapan->id] = 0;
            }
            foreach ($detil_status as $detil){
                // dd($detil);
                $count_per_tahapan[$detil->kegiatan_tahapan->id_tahapan]++;
            }
            $status_per_tahapan = [];
            foreach ($count_per_tahapan as $tahapan => $count) {
                $kegiatanCount = KegiatanTahapanModel::where('id_tahapan', $tahapan)->count();
            
                if ($count == $kegiatanCount)
                    $status_per_tahapan[$tahapan] = 'yes';
                else if ($count == 0)
                    $status_per_tahapan[$tahapan] = 'no';
                else
                    $status_per_tahapan[$tahapan] = 'process';
            }
            $pelatihan_progres[$pelatihan->id] = $status_per_tahapan;
        }

        $tahapanKegiatan = KegiatanTahapanModel::with('tahapan')->get()->groupBy('id_tahapan');


        $bidang_pelatihan = BidangPelatihanModel::all();

        return view('pelatihan.pelatihanBerlangsung_slides', ['pelatihans' => $pelatihans, 'pelatihan_progres'=>$pelatihan_progres,'tahapanKegiatan'=>$tahapanKegiatan,'bidangs'=>$bidang_pelatihan,'tahapans'=>$tahapans, 'querypelatihan'=> request('querypelatihan')]);
    }
}
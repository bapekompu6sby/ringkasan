<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use App\Models\TahapanModel;
use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\DetilStatusModel;
use App\Models\BidangPelatihanModel;
use App\Models\KegiatanTahapanModel;

class PelatihanStatusController extends Controller
{
    public function pelatihan_kelolaStatus($id)
    {
        $status = StatusModel::where('id_pelatihan', $id)->first();
        $detil_status = DetilStatusModel::where('id_status', $status->id)->get();
        $tahapanKegiatan = KegiatanTahapanModel::with('tahapan')->get()->groupBy('id_tahapan');
        $pelatihan = PelatihanModel::find($id);
        // dd($detil_status);
        return view('pelatihan.pelatihanStatus_kelola', ['tahapanKegiatan' => $tahapanKegiatan,'pelatihan' => $pelatihan,'status' => $status, 'detil_status' => $detil_status]);
    }
    public function pelatihan_ceklisStatus($id_pl, $id_kg)
    {
        $status = StatusModel::where('id_pelatihan', $id_pl)->first();
        $detil_status = DetilStatusModel::where('id_status', $status->id)->where('id_kegiatan_tahapan', $id_kg)->first();
        if ($detil_status) {
            $detil_status->delete();
        } else {
            $lastRecord = DetilStatusModel::latest('id')->first();
            $number = 1;
            if ($lastRecord) {
                $lastNumber = intval(substr($lastRecord->id, 3));
                $number = ($lastNumber < 99999) ? $lastNumber + 1 : 1;
            }
            $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

            DetilStatusModel::create([
                'id' => $newId,
                'id_status' => $status->id,
                'id_kegiatan_tahapan' => $id_kg,
            ]);
        }

        //Update Status Pelatihan Telah Selesai
        if (DetilStatusModel::where('id_status', $status->id)->count() == KegiatanTahapanModel::all()->count()) {
            StatusModel::find($status->id)->update(['ket_status' => 'Selesai']);
        }

        return redirect()->back()->with('success', 'Status Pelatihan berhasil diperbarui')->with('popUp_title','Updated!');
    }

    public function pelatihan_cekStatus($id)
    {
        $status = StatusModel::where('id_pelatihan', $id)->first();
        $detil_status = DetilStatusModel::with('kegiatan_tahapan')->where('id_status', $status->id)->get();
        $pelatihan = PelatihanModel::find($id);
        $tahapans = TahapanModel::all();
        $tahapans_kegiatan = TahapanModel::all();
        
        $count_per_tahapan = [];
        foreach ($tahapans as $tahapan){
            $count_per_tahapan[$tahapan->id] = 0;
        }
        foreach ($detil_status as $detil){
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
        // dd($status_per_tahapan);

        return view('pelatihan.pelatihanStatus_cek', ['tahapans' => $tahapans_kegiatan,'pelatihan' => $pelatihan,'status' => $status, 'detil_status' => $detil_status,'status_per_tahapan'=>$status_per_tahapan]);
    }

}
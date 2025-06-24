<?php

namespace App\Http\Controllers;

use App\Models\KegiatanSopModel;

class SopPelatihanController extends Controller
{
    public function sopPelatihan()
    {
        $sopKegiatan = KegiatanSopModel::with('sop')->get()->groupBy('sop');

        // dd($sopKegiatan);
        return view('sop_pelatihan.sopPelatihan',['sopKegiatan' => $sopKegiatan]);
    }
}
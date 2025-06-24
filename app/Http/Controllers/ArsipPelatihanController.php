<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PelatihanModel;

class ArsipPelatihanController extends Controller
{

    public function arsip_pelatihan(Request $request)
    {
        if ($request->has('querypelatihan') && $request->has('queryperiode')) {
            $querypelatihan = request('querypelatihan');
            $queryperiode = request('queryperiode');
            $pelatihan = PelatihanModel::with('jenis_pelatihan', 'bidang_pelatihan', 'model_pelatihan', 'status')
                ->whereHas('status', function ($query) use ($querypelatihan, $queryperiode) {
                    $query->where('ket_status', 'Selesai');
                    if ($querypelatihan) {
                        $query->where('nama', 'like', '%' . $querypelatihan . '%');
                    }
                    if ($queryperiode) {
                        $query->where('tahun_periode', '=', $queryperiode);
                    }
                })->get();
        } else {
            $pelatihan = PelatihanModel::with('jenis_pelatihan', 'bidang_pelatihan', 'model_pelatihan', 'status')
                ->whereHas('status', function ($query) {
                    $query->where('ket_status', 'Selesai');
                })->get();
        }

        return view('pelatihan.pelatihanArsip', ['pelatihans' => $pelatihan]);
    }

}
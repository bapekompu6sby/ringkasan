<?php

namespace App\Http\Controllers;

use App\Models\StatusModel;
use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\JenisPelatihanModel;
use App\Models\ModelPelatihanModel;
use App\Models\BidangPelatihanModel;
use Illuminate\Http\RedirectResponse;

class JadwalPelatihanController extends Controller
{
    public function jadwalPelatihan()
    {
        $jadwal_pelatihan = PelatihanModel::with('jenis_pelatihan','bidang_pelatihan','model_pelatihan','status')->whereHas('status', function ($query) {
            $query->where('ket_status', '=', 'Terjadwal'); })->orderBy('tanggal_mulai','asc')->get();
        return view('jadwal_pelatihan.jadwalPelatihan',['jadwals' => $jadwal_pelatihan]);
    }
    public function jadwalPelatihan_tambah()
    {
        $jenis_pelatihan = JenisPelatihanModel::all();
        $bidang_pelatihan = BidangPelatihanModel::all();
        $model_pelatihan = ModelPelatihanModel::all();
        return view('jadwal_pelatihan.jadwalPelatihan_tambah',['jeniss' => $jenis_pelatihan,'bidangs' => $bidang_pelatihan, 'models' => $model_pelatihan]);
    }
    public function jadwalPelatihan_insert(Request $request): RedirectResponse
    {
        if (!$request->validate([
            'nama' => 'required',
            'id_jenis' => 'required',
            'id_bidang' => 'required',
            'id_model' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'tahun_periode' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
                'id_jenis',
                'id_bidang',
                'id_model',
                'tanggal_mulai',
                'tanggal_selesai',
                'tahun_periode',
            ]);
        }
        

        $lastRecordPelatihan = PelatihanModel::latest('id')->first();
        $numberPelatihan = 1;
        if ($lastRecordPelatihan) {
            $lastNumber = intval(substr($lastRecordPelatihan->id, 2));
            // dd($lastNumber);
            $numberPelatihan = ($lastNumber < 99999) ? $lastNumber + 1 : 1;
        }
        $newIdPelatihan = 'PL' . str_pad($numberPelatihan, 5, '0', STR_PAD_LEFT);

        $request->merge(['id' => $newIdPelatihan]);

        PelatihanModel::create($request->all());

        $lastRecordStatus = StatusModel::latest('id')->first();
        $numberStatus = 1;
        if ($lastRecordStatus) {
            $lastNumber = intval(substr($lastRecordStatus->id, 2));
            $numberStatus = ($lastNumber < 99999) ? $lastNumber + 1 : 1;
        }
        $newIdStatus = 'ST' . str_pad($numberStatus, 5, '0', STR_PAD_LEFT);

        StatusModel::create([
            'id' => $newIdStatus,
            'id_pelatihan' => $newIdPelatihan,
            'ket_status' => 'Terjadwal',
        ]);

        return redirect('/jadwal-pelatihan')->with(['success' => 'Jadwal pelatihan berhasil ditambahkan', 'popUp_title' => 'Added!']);
    }
    public function jadwalPelatihan_view($id){
        $pelatihan = PelatihanModel::with(['jenis_pelatihan', 'bidang_pelatihan', 'model_pelatihan'])->find($id);


        // dd($pelatihan);

        return view('jadwal_pelatihan.jadwalPelatihan_view', ['pelatihan' => $pelatihan]);
    }
    public function jadwalPelatihan_start($id){
        StatusModel::where('id_pelatihan', $id)->update(['ket_status' => 'Sedang berlangsung']);

        return redirect('/pelatihan-berlangsung')->with(['success' => 'Pelatihan telah dimulai', 'popUp_title' => 'Started!']);
    }
    public function jadwalPelatihan_edit($id){
        $jenis_pelatihan = JenisPelatihanModel::all();
        $bidang_pelatihan = BidangPelatihanModel::all();
        $model_pelatihan = ModelPelatihanModel::all();
        $pelatihan = PelatihanModel::find($id);

        return view('jadwal_pelatihan.jadwalPelatihan_edit', ['jeniss' => $jenis_pelatihan ,'bidangs' =>$bidang_pelatihan, 'models' => $model_pelatihan,'pelatihan' => $pelatihan]);
    }
    public function jadwalPelatihan_update(Request $request){
        if (!$request->validate([
            'nama' => 'required',
            'id_jenis' => 'required',
            'id_bidang' => 'required',
            'id_model' => 'required',
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required',
            'tahun_periode' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'nama',
                'id_jenis',
                'id_bidang',
                'id_model',
                'tanggal_mulai',
                'tanggal_selesai',
                'tahun_periode',
            ]);
        }

        $pelatihan = PelatihanModel::find($request->id);
        $pelatihan->update($request->all());

        return redirect('/jadwal-pelatihan')->with('success', 'Jadwal pelatihan berhasil diubah')->with('popUp_title','Updated!');
    }
    public function jadwalPelatihan_delete($id){
        StatusModel::where('id_pelatihan', $id)->delete();
        PelatihanModel::find($id)->delete();

        return redirect('/jadwal-pelatihan')->with(['success' => 'Jadwal pelatihan berhasil dihapus', 'popUp_title' => 'Deleted!']);
    }

}
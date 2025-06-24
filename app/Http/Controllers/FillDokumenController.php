<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Imports\UserImport;
use App\Models\StatusModel;
use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\DetilStatusModel;
use App\Models\KegiatantahapanModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class FillDokumenController extends Controller
{
    public function form_dokumen_pelatihan_create($id_pl,$id_kthp)
    {
        $pelatihan = PelatihanModel::with('model_pelatihan','status')->find($id_pl);
        // dd($pelatihan->model_pelatihan->id);
        $status = StatusModel::where('id_pelatihan', $id_pl)->first();
        
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_kegiatan_break = str_replace([' ', ',','-'], '', $nama_kegiatan);

        return view('dokumen.form.create.'. $nama_kegiatan_break ,[
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'nama_fungsi' => $nama_kegiatan_break
       ]);
    }
    public function form_dokumen_pelatihan_upload($id_pl,$id_kthp)
    {
        $pelatihan = PelatihanModel::with('model_pelatihan','status')->find($id_pl);
        $status = StatusModel::where('id_pelatihan', $id_pl)->first();
        
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_kegiatan_break = str_replace([' ', ',','-'], '', $nama_kegiatan);

        return view('dokumen.form.upload.'. $nama_kegiatan_break ,[
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'nama_fungsi' => $nama_kegiatan_break
       ]);
    }
    public function download_requirement($file){
        $path = public_path().'/assets/requirements/'. $file . '.xlsx';
        return response()->download($path);
    }

    public function recreate_dokumen($id_pl,$id_kthp){
        $pelatihan = PelatihanModel::with('model_pelatihan','status')->find($id_pl);
        $status = StatusModel::where('id_pelatihan', $id_pl)->first();
        
        $kegiatanTahapan = KegiatanTahapanModel::with('tahapan')->find($id_kthp);
        $id_tahapan = $kegiatanTahapan->id_tahapan;
        // dd($id_tahapan);
        $no_thp = intval(substr($id_tahapan, 2));

        $file = DetilStatusModel::where('id_status', $status->id)->where('id_kegiatan_tahapan', $id_kthp)->first();
        if($file){
            if($file->keterangan == 'Ditolak'){
                $path = public_path('assets/dokumen/' . $file->file);
                unlink($path);
                $file->delete();

                return redirect('/dokumen-pelatihan-'. $id_pl . '/' . $no_thp . '/tahapan-' . $id_tahapan);
            }
            else{
                return redirect()->back()->with(['error' => 'Dokumen ini telah dibuat dan disetujui', 'popUp_title' => 'Error!']);
            }
        }


    }

    ////////////////////////////// CREATE ////////////////////////////////////

    public function create_SuratUndanganRapatPersiapan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'surat_perintah' => 'required',
            'nomor_surat_perintah' => 'required',
            'tanggal_surat_perintah' => 'required',
            'hal_surat_perintah' => 'required',
            'tanggal' => 'required',
            'waktu_mulai' => 'required', 
            'zoom_id' => 'required',
            'passcode' => 'required',
            'req_udRapat' => 'required|mimes:xls,xlsx',
        ])) {
            return redirect()->back()->withErrors([
                'nomor_surat',
                'surat_perintah',
                'nomor_surat_perintah',
                'tanggal_surat_perintah',
                'hal_surat_perintah',
                'tanggal',
                'waktu_mulai', 
                'zoom_id',
                'passcode',
                'req_udRapat',
            ]);
        }

        // dd($request->file('file'));

        $file = $request->file('req_udRapat');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'tim_pusbangkom' => $row[0],
                'tim_bapekom' => $row[1],
                'tembusan' => $row[2],
            ];
        });

        $req = $req->toArray();

        $pelatihan = PelatihanModel::find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    public function create_SuratPermohonanMembukadanMenghadiri($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'kata_ganti' => 'required',
            'surat_perintah' => 'required',
            'nomor_surat_perintah' => 'required',
            'tanggal_surat_perintah' => 'required',
            'hal_surat_perintah' => 'required',
            'nama_yth' => 'required',
            'lokasi' => 'required',
            'waktu_mulai' => 'required',
            'zoom_id' => 'required',
            'passcode' => 'required',
            'req_suratPermohonanMembuka' => 'required|mimes:xls,xlsx',
        ])) {
            return redirect()->back()->withErrors([
                'nomor_surat',
                'kata_ganti',
                'surat_perintah',
                'nomor_surat_perintah',
                'tanggal_surat_perintah',
                'hal_surat_perintah',
                'nama_yth',
                'lokasi',
                'waktu_mulai',
                'zoom_id',
                'passcode',
                'req_suratPermohonanMembuka',
            ]);
        }
    
        $file = $request->file('req_suratPermohonanMembuka');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'tembusan' => $row[0],
            ];
        });

        $req = $req->forget(0);

        $pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);
    }

    public function create_SuratUndanganMenghadiriPembukaan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'kata_ganti' => 'required',
            'nama_yth' => 'required',
            'lokasi' => 'required',
            'waktu_mulai' => 'required',
            'zoom_id' => 'required',
            'passcode' => 'required',
            'req_suratUndanganMenghadiriPembukaan' => 'required|mimes:xls,xlsx',
            ])) {
                return redirect()->back()->withErrors([
                    'nomor_surat',
                    'kata_ganti',
                    'nama_yth',
                    'lokasi',
                    'waktu_mulai',
                    'zoom_id',
                    'passcode',
                    'req_suratUndanganMenghadiriPembukaan',
                ]);
            }
    
        $file = $request->file('req_suratUndanganMenghadiriPembukaan');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'tembusan' => $row[0],
            ];
        });

        $req = $req->forget(0);

        $pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }


    public function create_SuratUndanganRapatEvaluasi($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'surat_edaran' => 'required',
            'nomor_surat_edaran' => 'required',
            'hal_surat_edaran' => 'required',
            'tanggal' => 'required',
            'waktu_mulai' => 'required', 
            'zoom_id' => 'required',
            'passcode' => 'required',
            'req_udRapat' => 'required|mimes:xls,xlsx',
            ])) {
                return redirect()->back()->withErrors([
                    'nomor_surat',
                    'surat_edaran',
                    'nomor_surat_edaran',
                    'hal_surat_edaran',
                    'tanggal',
                    'waktu_mulai', 
                    'zoom_id',
                    'passcode',
                    'req_udRapat',
                ]);
            }

        // dd($request->file('file'));

        $file = $request->file('req_udRapat');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'tim_pengajar' => $row[0],
                'tim_pusbangkom' => $row[1],
                'tim_bapekom' => $row[2],
                'tembusan' => $row[3],
            ];
        });

        // dd($req);

        $req = $req->toArray();

        $pelatihan = PelatihanModel::find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    public function create_LaporanPembukaan($id_pl, $id_kthp, Request $request)
    {
        // dd($request->all());
        if (!$request->validate([
            'tanggal' => 'required',
            'kepala_bpsdm' => 'required',
            'tujuan' => 'required',
            'req_laporanPembukaan' => 'required|mimes:xls,xlsx',
            'pantun' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'tanggal',
                'kepala_bpsdm',
                'tujuan',
                'req_laporanPembukaan',
                'pantun',
            ]);
        }
        // dd($request->file('file'));
        $baris_pantun = explode("\n", $request->pantun);
            $pantun = [];
            
            // Variabel sementara untuk menyimpan indeks loop
            $index = 0;
            
            foreach($baris_pantun as $baris){
                // Mengisi array pantun dengan baris-baris pantun
                $pantun[$index] = $baris;
                
                // Menambahkan nilai indeks untuk iterasi berikutnya
                $index++;
            }

        $file = $request->file('req_laporanPembukaan');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'kepada_yth' => $row[0],
                'nama_yth' => $row[1],
                'yg_dihormati' => $row[2],
                'dasar_pelaksanaan' => $row[3],
                'no_peserta' => $row[4],
                'unit_kerja_peserta' => $row[5],
                'jumlah_peserta' => $row[6],
                'no_kurikulum' => $row[7],
                'mapel_kurikulum' => $row[8],
                'jp_kurikulum' => $row[9],
                'evaluasi' => $row[10],
            ];
        });

        $req = $req->forget(0);

        $data_req = [];
        $data_req['kepada_yth'] = [];
        $data_req['nama_yth'] = [];
        $data_req['yg_dihormati'] = [];
        $data_req['dasar_pelaksanaan'] = [];
        $data_req['no_peserta'] = [];
        $data_req['unit_kerja_peserta'] = [];
        $data_req['jumlah_peserta'] = [];
        $data_req['no_kurikulum'] = [];
        $data_req['mapel_kurikulum'] = [];
        $data_req['jp_kurikulum'] = [];
        $data_req['evaluasi'] = [];

        foreach($req as $item){
            if($item['kepada_yth'] != null){
                array_push($data_req['kepada_yth'], $item['kepada_yth']);
            }
            if($item['nama_yth'] != null){
                array_push($data_req['nama_yth'], $item['nama_yth']);
            }
            if($item['yg_dihormati'] != null){
                array_push($data_req['yg_dihormati'], $item['yg_dihormati']);
            }
            if($item['dasar_pelaksanaan'] != null){
                array_push($data_req['dasar_pelaksanaan'], $item['dasar_pelaksanaan']);
            }
            if($item['no_peserta'] != null){
                array_push($data_req['no_peserta'], $item['no_peserta']);
            }
            if($item['unit_kerja_peserta'] != null){
                array_push($data_req['unit_kerja_peserta'], $item['unit_kerja_peserta']);
            }
            if($item['jumlah_peserta'] != null){
                array_push($data_req['jumlah_peserta'], $item['jumlah_peserta']);
            }
            if($item['no_kurikulum'] != null){
                array_push($data_req['no_kurikulum'], $item['no_kurikulum']);
            }
            if($item['mapel_kurikulum'] != null){
                array_push($data_req['mapel_kurikulum'], $item['mapel_kurikulum']);
            }
            if($item['jp_kurikulum'] != null){
                array_push($data_req['jp_kurikulum'], $item['jp_kurikulum']);
            }
            if($item['evaluasi'] != null){
                array_push($data_req['evaluasi'], $item['evaluasi']);
            }
        }
        // dd($data_req['kepala_bpsdm']);

        array_shift($data_req['no_peserta']);
        array_shift($data_req['unit_kerja_peserta']);
        array_shift($data_req['jumlah_peserta']);

        array_shift($data_req['no_kurikulum']);
        array_shift($data_req['mapel_kurikulum']);
        array_shift($data_req['jp_kurikulum']);
         

        $pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'pantun' => $pantun,
            'request' => $request,
            'logo' => $logo,
            'data' => $data_req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    public function create_BeritaAcaraKelulusan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'jumlah_peserta' => 'required', 
            'memuaskan' => 'required',
            'baik_sekali' => 'required',
            'baik' => 'required',
            'req_BA' => 'required|mimes:xls,xlsx',
        ])) {
            return redirect()->back()->withErrors([
                'nomor_surat',
                'jumlah_peserta', 
                'memuaskan',
                'baik_sekali',
                'baik',
                'req_BA',
            ]);
        }

        // dd($request->file('file'));

        $file = $request->file('req_BA');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'nama_lengkap' => $row[0],
                'nip' => $row[1],
                'jabatan' => $row[2],
                'unit_kerja' => $row[3],
            ];
        });

        $req = $req->forget(0);

        // dd($req);

        $req = $req->toArray();

        $pelatihan = PelatihanModel::find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    public function create_SuratPermohonanMenutupdanMenghadiri($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'kata_ganti' => 'required',
            'nama_yth' => 'required',
            'lokasi' => 'required',
            'waktu_mulai' => 'required',
            'zoom_id' => 'required',
            'passcode' => 'required',
            'req_suratPermohonanMenutup' => 'required|mimes:xls,xlsx',
        ])) {
            return redirect()->back()->withErrors([
                'nomor_surat',
                'kata_ganti',
                'nama_yth',
                'lokasi',
                'waktu_mulai',
                'zoom_id',
                'passcode',
                'req_suratPermohonanMenutup',
            ]);
        }
    
        $file = $request->file('req_suratPermohonanMenutup');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'tembusan' => $row[0],
            ];
        });

        $req = $req->forget(0);

        $pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);
    }

    public function create_SuratUndanganMenghadiriPenutupan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'kata_ganti' => 'required',
            'nama_yth' => 'required',
            'lokasi' => 'required',
            'waktu_mulai' => 'required',
            'zoom_id' => 'required',
            'passcode' => 'required',
            'req_suratUndanganMenghadiriPenutupan' => 'required|mimes:xls,xlsx',
        ])) {
            return redirect()->back()->withErrors([
                'nomor_surat',
                'kata_ganti',
                'nama_yth',
                'lokasi',
                'waktu_mulai',
                'zoom_id',
                'passcode',
                'req_suratUndanganMenghadiriPenutupan',
            ]);
        }
    
        $file = $request->file('req_suratUndanganMenghadiriPenutupan');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'tembusan' => $row[0],
            ];
        });

        $req = $req->forget(0);

        $pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    public function create_LaporanPenutupan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'tanggal' => 'required',
            'kepala_bpsdm' => 'required',
            'jumlah_peserta' => 'required',
            'jumlah_peserta_hadir' => 'required',
            'peserta_male' => 'required',
            'peserta_female' => 'required',
            'req_laporanPenutupan' => 'required|mimes:xls,xlsx',
            'pantun' => 'required',
        ])) {
            return redirect()->back()->withErrors([
                'tanggal',
                'kepala_bpsdm',
                'jumlah_peserta',
                'jumlah_peserta_hadir',
                'peserta_male',
                'peserta_female',
                'req_laporanPenutupan',
                'pantun',
            ]);
        }
        
        $baris_pantun = explode("\n", $request->pantun);
        $pantun = [];
        
        // Variabel sementara untuk menyimpan indeks loop
        $index = 0;
        
        foreach($baris_pantun as $baris){
            // Mengisi array pantun dengan baris-baris pantun
            $pantun[$index] = $baris;
            
            // Menambahkan nilai indeks untuk iterasi berikutnya
            $index++;
        }
            
        // dd($request->file('file'));

        $file = $request->file('req_laporanPenutupan');

        $data_pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $model = $data_pelatihan->model_pelatihan->id;

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        if ($model == 'MP001'){
            $req = $req[0]->map(function($row) {
                return [
                    'kepada_yth' => $row[0],
                    'nama_yth' => $row[1],
                    'yg_dihormati' => $row[2],
                    'dasar_hukum_penyelenggaraan' => $row[3],
                    'evaluasi_elearning' => $row[4],
                    'evaluasi_manajemen' => $row[5],
                    'best3_peringkat' => $row[6],
                    'best3_nama' => $row[7],
                    'best3_unit_kerja' => $row[8],
                    'best3_nilai' => $row[9],
                    'best3_predikat' => $row[10],
                ];
            });
        }
        elseif ($model == 'MP002'){
            $req = $req[0]->map(function($row) {
                return [
                    'kepada_yth' => $row[0],
                    'nama_yth' => $row[1],
                    'yg_dihormati' => $row[2],
                    'dasar_hukum_penyelenggaraan' => $row[3],
                    'evaluasi_elearning' => $row[4],
                    'best3_peringkat' => $row[5],
                    'best3_nama' => $row[6],
                    'best3_unit_kerja' => $row[7],
                    'best3_nilai' => $row[8],
                    'best3_predikat' => $row[9],
                ];
            });
        }
        elseif ($model == 'MP003'){
            $req = $req[0]->map(function($row) {
                return [
                    'kepada_yth' => $row[0],
                    'nama_yth' => $row[1],
                    'yg_dihormati' => $row[2],
                    'dasar_hukum_penyelenggaraan' => $row[3],
                    'evaluasi_manajemen' => $row[4],
                    'best3_peringkat' => $row[5],
                    'best3_nama' => $row[6],
                    'best3_unit_kerja' => $row[7],
                    'best3_nilai' => $row[8],
                    'best3_predikat' => $row[9],
                ];
            });
        }
        

        $req = $req->forget(0);

        $data_req = [];
        $data_req['kepada_yth'] = [];
        $data_req['nama_yth'] = [];
        $data_req['yg_dihormati'] = [];
        $data_req['dasar_hukum_penyelenggaraan'] = [];
        if ($model == 'MP001'){
            $data_req['evaluasi_elearning'] = [];
            $data_req['evaluasi_manajemen'] = [];
        }
        elseif ($model == 'MP002'){
            $data_req['evaluasi_elearning'] = [];
        }
        elseif ($model == 'MP003'){
            $data_req['evaluasi_manajemen'] = [];
        }
        $data_req['best3_peringkat'] = [];
        $data_req['best3_nama'] = [];
        $data_req['best3_unit_kerja'] = [];
        $data_req['best3_nilai'] = [];
        $data_req['best3_predikat'] = [];


        foreach($req as $item){
            if($item['kepada_yth'] != null){
                array_push($data_req['kepada_yth'], $item['kepada_yth']);
            }
            if($item['nama_yth'] != null){
                array_push($data_req['nama_yth'], $item['nama_yth']);
            }
            if($item['yg_dihormati'] != null){
                array_push($data_req['yg_dihormati'], $item['yg_dihormati']);
            }
            if($item['dasar_hukum_penyelenggaraan'] != null){
                array_push($data_req['dasar_hukum_penyelenggaraan'], $item['dasar_hukum_penyelenggaraan']);
            }
            if($model == 'MP001'){
                if($item['evaluasi_elearning'] != null){
                    array_push($data_req['evaluasi_elearning'], $item['evaluasi_elearning']);
                }
                if($item['evaluasi_manajemen'] != null){
                    array_push($data_req['evaluasi_manajemen'], $item['evaluasi_manajemen']);
                }
            }
            elseif($model == 'MP002'){
                if($item['evaluasi_elearning'] != null){
                    array_push($data_req['evaluasi_elearning'], $item['evaluasi_elearning']);
                }
            }
            elseif($model == 'MP003'){
                if($item['evaluasi_manajemen'] != null){
                    array_push($data_req['evaluasi_manajemen'], $item['evaluasi_manajemen']);
                }
            }
            if($item['best3_peringkat'] != null){
                array_push($data_req['best3_peringkat'], $item['best3_peringkat']);
            }
            if($item['best3_nama'] != null){
                array_push($data_req['best3_nama'], $item['best3_nama']);
            }
            if($item['best3_unit_kerja'] != null){
                array_push($data_req['best3_unit_kerja'], $item['best3_unit_kerja']);
            }
            if($item['best3_nilai'] != null){
                array_push($data_req['best3_nilai'], $item['best3_nilai']);
            }
            if($item['best3_predikat'] != null){
                array_push($data_req['best3_predikat'], $item['best3_predikat']);
            }
        }
        

        array_shift($data_req['best3_peringkat']);
        array_shift($data_req['best3_nama']);
        array_shift($data_req['best3_unit_kerja']);
        array_shift($data_req['best3_nilai']);
        array_shift($data_req['best3_predikat']);

        // dd($data_req);
         

        $pelatihan = PelatihanModel::with('model_pelatihan')->find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'pantun' => $pantun,
            'logo' => $logo,
            'data' => $data_req,
            // 'total_jp' => $total_jp,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    public function create_SuratPengembalianPeserta($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'nomor_surat' => 'required',
            'req_pengembalian' => 'required|mimes:xls,xlsx',
        ])) {
            return redirect()->back()->withErrors([
                'nomor_surat',
                'req_pengembalian',
            ]);
        }

        // dd($request->file('file'));

        $file = $request->file('req_pengembalian');

        // get collection from each row
        $req = Excel::toCollection(new UserImport, $file);
        $req = $req[0]->map(function($row) {
            return [
                'no' => $row[0],
                'nama' => $row[1],
                'nip/nrp' => $row[2],
                'unit_kerja' => $row[3],
                'peringkat' => $row[4],
                'unit_kerja_pengutus'=> $row[6],
                'tembusan' => $row[8],
            ];
        });

        $req = $req->toArray();

        $pelatihan = PelatihanModel::find($id_pl);
        $kegiatanTahapan = KegiatanTahapanModel::find($id_kthp);
        $nama_kegiatan = $kegiatanTahapan->dokumen;
        $nama_fungsi = str_replace([' ', ',','-'], '', $nama_kegiatan);

        $path = public_path().'/assets/images/pupr.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $logo = 'data:image/'. $type . ';base64,'. base64_encode($data);

        // Kirim objek $request bersama dengan data lainnya ke tampilan HTML
        $data = [
            'pelatihan' => $pelatihan,
            'kegiatan' => $kegiatanTahapan,
            'request' => $request,
            'logo' => $logo,
            'data' => $req,
        ];

        // Tampilkan view HTML dengan nilai-nilai dari objek $request
        $html_content = view('dokumen.cetak.' . $nama_fungsi, $data)->render();

        // $options = new Options();
        // $options->set('isHtml5ParserEnabled', true);
        // $options->set('isCssFloatEnabled', true);

        $pdf = new Dompdf();
        $pdf->loadHtml($html_content);
        $pdf->setPaper('A4', 'portrait');
        $pdf->render();

        $pdf_content = $pdf->output();
        return view('dokumen.previewDokumenCetak', ['pdf_content' => $pdf_content,'pelatihan' => $pelatihan,
        'kegiatan' => $kegiatanTahapan, 'nama_fungsi' => $nama_fungsi, 'kegiatan' => $kegiatanTahapan]);

    }

    ////////////////////////////// UPLOAD ////////////////////////////////////

    public function upload_SuratUndanganRapatPersiapan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratUndangan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratUndangan'
            ]);
        }

        $extension = $request->file('suratUndangan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratUndangan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_NotulenRapatPersiapan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'notulenRapatPersiapan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'notulenRapatPersiapan'
            ]);
        }

        $extension = $request->file('notulenRapatPersiapan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('notulenRapatPersiapan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }

    }

    public function upload_PedomanPelatihan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'pedomanPelatihan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'pedomanPelatihan'
            ]);
        }

        $extension = $request->file('pedomanPelatihan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('pedomanPelatihan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }

    }

    public function upload_SuratPenetapanPengajar($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratPenetapanPengajar' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratPenetapanPengajar'
            ]);
        }

        $extension = $request->file('suratPenetapanPengajar')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratPenetapanPengajar')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }

    public function upload_SuratPenetapanPeserta($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratPenetapanPeserta' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratPenetapanPeserta'
            ]);
        }

        $extension = $request->file('suratPenetapanPeserta')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratPenetapanPeserta')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }

    }

    public function upload_SuratPemanggilanPeserta($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratPemanggilanPeserta' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratPemanggilanPeserta'
            ]);
        }

        $extension = $request->file('suratPemanggilanPeserta')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratPemanggilanPeserta')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }

    }

    public function upload_FormBiodataTF4($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'formBiodata' => 'required|mimes:xls,xlsx,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'formBiodata'
            ]);
        }

        $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('formBiodata')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }

    public function upload_SKPelatihan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'skPelatihan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'skPelatihan'
            ]);
        }

        $extension = $request->file('skPelatihan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('skPelatihan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }



    }

    public function upload_SuratPermohonanMembukadanMenghadiri($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratPermohonan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratPermohonan'
            ]);
        }

        $extension = $request->file('suratPermohonan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratPermohonan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_SuratUndanganMenghadiriPembukaan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratUndangan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratUndangan'
            ]);
        }

        $extension = $request->file('suratUndangan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratUndangan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_SambutanPembukaanKepalaPusat($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'sambutanPembukaanKapus' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'sambutanPembukaanKapus'
            ]);
        }

        $extension = $request->file('sambutanPembukaanKapus')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('sambutanPembukaanKapus')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }

    public function upload_LaporanPembukaan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'laporanPembukaan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'laporanPembukaan'
            ]);
        }

        $extension = $request->file('laporanPembukaan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('laporanPembukaan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_VirtualBackgroundSpandukBackdrop($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'virtualBg' => 'required|mimes:jpg, jpeg, zip, rar',
        ])) {
            return redirect()->back()->withErrors([
                'virtualBg'
            ]);
        }

        $extension = $request->file('virtualBg')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('virtualBg')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
       
    }

    public function upload_DokumentasiCeremonyPembukaan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'dokumentasiCeremony' => 'required|mimes:jpg,jpeg,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'dokumentasiCeremony'
            ]);
        }

        $extension = $request->file('dokumentasiCeremony')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('dokumentasiCeremony')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_BahanTayangPengajar($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'bahanTayang' => 'required|mimes:zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'bahanTayang'
            ]);
        }

        $extension = $request->file('bahanTayang')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('bahanTayang')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_LaporandanBahanTayangSeminarPeserta($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'laporanBahanTayangSeminar' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'laporanBahanTayangSeminar'
            ]);
        }

        $extension = $request->file('laporanBahanTayangSeminar')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('laporanBahanTayangSeminar')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }

    }

    public function upload_BiodataPengajar($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'biodataPengajar' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'biodataPengajar'
            ]);
        }

        $extension = $request->file('biodataPengajar')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('biodataPengajar')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }

    }

    public function upload_AbsensiPeserta($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'absensiPeserta' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'absensiPeserta'
            ]);
        }

        $extension = $request->file('absensiPeserta')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('absensiPeserta')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_AbsensiPengajar($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'absensiPengajar' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'absensiPengajar'
            ]);
        }

        $extension = $request->file('absensiPengajar')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('absensiPengajar')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_FormPenilaianSikapPerilaku($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'formPenilaian' => 'required|mimes:xls,xlsx,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'formPenilaian'
            ]);
        }

        $extension = $request->file('formPenilaian')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('formPenilaian')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_SuratUndanganRapatEvaluasi($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratUndangan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratUndangan'
            ]);
        }

        $extension = $request->file('suratUndangan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratUndangan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_BeritaAcaraKelulusan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'beritaAcaraKelulusan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'beritaAcaraKelulusan'
            ]);
        }

        $extension = $request->file('beritaAcaraKelulusan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('beritaAcaraKelulusan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_SuratPermohonanMenutupdanMenghadiri($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratPermohonan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratPermohonan'
            ]);
        }

        $extension = $request->file('suratPermohonan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratPermohonan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_SuratUndanganMenghadiriPenutupan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratUndangan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratUndangan'
            ]);
        }

        $extension = $request->file('suratUndangan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratUndangan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_SambutanPenutupanKepalaPusat($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'sambutanPenutupanKapus' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'sambutanPenutupanKapus'
            ]);
        }

        $extension = $request->file('sambutanPenutupanKapus')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('sambutanPenutupanKapus')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }

    public function upload_LaporanPenutupan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'laporanPenutupan' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'laporanPenutupan'
            ]);
        }

        $extension = $request->file('laporanPenutupan')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('laporanPenutupan')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_DokumentasiCeremonyPenutupan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'dokumentasiCeremony' => 'required|mimes:jpg,jpeg,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'dokumentasiCeremony'
            ]);
        }

        $extension = $request->file('dokumentasiCeremony')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('dokumentasiCeremony')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_SuratPengembalianPeserta($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'suratPengembalianPeserta' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'suratPengembalianPeserta'
            ]);
        }

        $extension = $request->file('suratPengembalianPeserta')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('suratPengembalianPeserta')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
    
    public function upload_SPMK($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'spmk' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'spmk'
            ]);
        }

        $extension = $request->file('spmk')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('spmk')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }


    }

    public function upload_LaporanAkhirPelatihan($id_pl, $id_kthp, Request $request)
    {
        if (!$request->validate([
            'laporanAkhir' => 'required|mimes:docx,pdf,zip,rar',
        ])) {
            return redirect()->back()->withErrors([
                'laporanAkhir'
            ]);
        }

        $extension = $request->file('laporanAkhir')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.' . $extension;

        $request->file('laporanAkhir')->move(public_path('assets/dokumen'), $fileName);

        // Ambil record terakhir dari tabel
        $lastRecord = DetilStatusModel::latest('id')->first();
        // Inisialisasi angka awal
        $number = 1;
        if ($lastRecord) {
            $lastNumber = intval(substr($lastRecord->id, 3));
            $number = ($lastNumber < 999) ? $lastNumber + 1 : 1;
        }
        // Format ulang ID dengan 'BP' diikuti oleh angka yang telah diincrement
        $newId = 'DST' . str_pad($number, 5, '0', STR_PAD_LEFT);

        $status = StatusModel::where('id_pelatihan', $id_pl)->first();


        // Tambahkan ID yang telah diincrement ke dalam request
        $requestData = [];
        $requestData['id'] = $newId;
        $requestData['id_status'] = $status->id;
        $requestData['id_kegiatan_tahapan'] = $id_kthp;
        $requestData['file'] = $fileName; 
        $requestData['keterangan'] = 'Terkirim';
        

        // Buat record baru menggunakan metode create
        DetilStatusModel::create($requestData);

        if (Auth::user()->role == 'petugas'){
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah diupload', 'popUp_title' => 'Added!']);
        }
    }
}
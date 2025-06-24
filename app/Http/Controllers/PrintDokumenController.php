<?php

namespace App\Http\Controllers;

use App\Imports\UserImport;
use App\Models\StatusModel;
use Illuminate\Http\Request;
use App\Models\PelatihanModel;
use App\Models\DetilStatusModel;
use App\Models\KegiatantahapanModel;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PrintDokumenController extends Controller
{
    ////////////////////////////// PRINT THE DOCUMENT////////////////////////////////////

    public function print_SuratUndanganRapatPersiapan($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
    }
    public function print_SuratPermohonanMembukadanMenghadiri($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }

        }
    public function print_SuratUndanganMenghadiriPembukaan($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }

    }
    public function print_LaporanPembukaan($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }

    }
    public function print_SuratUndanganRapatEvaluasi($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        

    }
    public function print_BeritaAcaraKelulusan($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }


    }
    public function print_SuratPermohonanMenutupdanMenghadiri($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        

    }
    public function print_SuratUndanganMenghadiriPenutupan($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }

    }
    public function print_LaporanPenutupan($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        

    }
    public function print_SuratPengembalianPeserta($id_pl, $id_kthp, Request $request)
    {
        // $extension = $request->file('formBiodata')->extension();
        $fileName = $id_pl . '_' . $id_kthp . '.pdf';

        // Ambil konten PDF dari request dan simpan ke file
        $pdf_content = base64_decode($request->pdf_content);
        file_put_contents(public_path('assets/dokumen/' . $fileName), $pdf_content);

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
            return redirect('/status-dokumen')->with(['success' => 'Dokumen telah dikirim dan sedang menunggu untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        elseif(Auth::user()->role == 'supervisi'){
            return redirect('/tinjau-dokumen')->with(['success' => 'Dokumen telah disimpan dan siap untuk ditinjau', 'popUp_title' => 'Sended!']);
        }
        

    }
}
@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
@if (!function_exists('tanggal_indo'))
@php
function tanggal_indo($tanggal){
    $bulan = array (
    1 =>'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
    );
    $pecahkan = explode('-', $tanggal);

    return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

function rentang_tgl($tgl_mulai, $tgl_selesai){
    $tgl_mulai = tanggal_indo($tgl_mulai);
    $tgl_selesai = tanggal_indo($tgl_selesai);
    $tgl_mulai_pecah = explode(' ', $tgl_mulai);
    $tgl_selesai_pecah = explode(' ', $tgl_selesai);
    if ($tgl_mulai_pecah[1] == $tgl_selesai_pecah[1]) {
        return $tgl_mulai_pecah[0] . ' s.d ' . $tgl_selesai_pecah[0] . ' ' . $tgl_mulai_pecah[1] . ' ' . $tgl_mulai_pecah[2];
    }
    return $tgl_mulai . ' s.d ' . $tgl_selesai;
}

function hari_indo($tanggal){
    if (date('l', strtotime($tanggal)) == 'Sunday') {
        return 'Minggu';
    } elseif (date('l', strtotime($tanggal)) == 'Monday') {
        return 'Senin';
    } elseif (date('l', strtotime($tanggal)) == 'Tuesday') {
        return 'Selasa';
    } elseif (date('l', strtotime($tanggal)) == 'Wednesday') {
        return 'Rabu';
    } elseif (date('l', strtotime($tanggal)) == 'Thursday') {
        return 'Kamis';
    } elseif (date('l', strtotime($tanggal)) == 'Friday') {
        return 'Jumat';
    } elseif (date('l', strtotime($tanggal)) == 'Saturday') {
        return 'Sabtu';
    }
    return date('l', strtotime($tanggal));
}
@endphp
@endif
<div class="app-content">
    @if(Session::has('success'))
        <p>ok</p>
        <script>
            Swal.fire({
                title: '{{ Session::get('popUp_title') }}',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    <div class="content-wrapper">
        <div class="container">
            <div class="card widget widget-info">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="settings-security-two-factor">
                                <h5><u>Detail Pelatihan</u></h5> 
                                <div class="row">
                                    <div class="col-8">
                                        <p><b>Nama Pelatihan:</b> {{ $pelatihan->nama }}</p>
                                        <p><b>Jenis Pelatihan:</b> {{ $pelatihan->jenis_pelatihan->nama}}</p>
                                        <p><b>Bidang Pelatihan:</b> {{ $pelatihan->bidang_pelatihan->nama}}</p>
                                        <p><b>Model Pelatihan:</b> {{ $pelatihan->model_pelatihan->nama}}</p>
                                    </div>
                                    <div class="col-4">
                                        <p><b>Tanggal Mulai:</b> {{ tanggal_indo($pelatihan->tanggal_mulai) }}</p>
                                        <p><b>Tanggal Selesai:</b> {{ tanggal_indo($pelatihan->tanggal_selesai) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="widget-info-container">
                                <div class="widget-info-image" >
                                    <img class="mt-5" src="{{ asset('assets/images/surat/surat_pemanggilan.png') }}" width=100 alt="">
                                </div>
                                <h5 class="widget-info-title">Surat Pemanggilan Peserta</h5>
                                <a href="/cetak-surat/form-pemanggilan-peserta/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="widget-info-container">
                                <div class="widget-info-image" >
                                    <img class="mt-5" src="{{ asset('assets/images/surat/surat_pengembalian.png') }}" width=100 alt="">
                                </div>
                                <h5 class="widget-info-title">Surat Pengembalian Peserta</h5>
                                <a href="/cetak-surat/form-pengembalian-peserta/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="widget-info-container">
                                <div class="widget-info-image" >
                                    <img class="mt-5" src="{{ asset('assets/images/surat/surat_keputusan.png') }}" width=100 alt="">
                                </div>
                                <h5 class="widget-info-title">Surat Keputusan Pelatihan</h5>
                                <a href="/cetak-surat/form-keputusan-pelatihan/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <div class="widget-info-container">
                                <div class="widget-info-image" >
                                    <img class="mt-5" src="{{ asset('assets/images/surat/surat_permohonan_kehadiran.png') }}" width=100 alt="">
                                </div>
                                <h5 class="widget-info-title">Surat Permohonan Kehadiran Pembukaan</h5>
                                <a href="/cetak-surat/form-permohonan-kehadiran-pembukaan/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="widget-info-container">
                                <div class="widget-info-image" >
                                    <img class="mt-5" src="{{ asset('assets/images/surat/surat_permohonan_kehadiran.png') }}" width=100 alt="">
                                </div>
                                <h5 class="widget-info-title">Surat Permohonan Kehadiran Penutupan</h5>
                                <a href="/cetak-surat/form-permohonan-kehadiran-penutupan/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="widget-info-container">
                                <div class="widget-info-image" >
                                    <img class="mt-5" src="{{ asset('assets/images/surat/surat_permohonan_sambutan.png') }}" width=100 alt="">
                                </div>
                                <h5 class="widget-info-title">Surat Permohonan Sambutan Pembukaan</h5>
                                <a href="/cetak-surat/form-permohonan-sambutan-pembukaan/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="widget-info-container">
                                <img class="mt-5" src="{{ asset('assets/images/surat/surat_permohonan_sambutan.png') }}" width=100 alt="">
                                <h5 class="widget-info-title">Surat Permohonan Sambutan Penutupan</h5>
                                <a href="/cetak-surat/form-permohonan-sambutan-penutupan/pelatihan-{{ $pelatihan->id }}" class="btn btn-primary widget-info-action no-m-b mt-2">Buat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
@endsection


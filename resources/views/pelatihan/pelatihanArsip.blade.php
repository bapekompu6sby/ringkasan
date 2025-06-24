@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
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
    <div class="content-wrapper">
        <div class="container">
            {{-- <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Arsip Pelatihan</h1>
                    </div>
                </div>
            </div> --}}
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="row mb-3">
                <form action="/arsip-pelatihan">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari pelatihan..." name="querypelatihan" value="{{ old('querypelatihan') }}">
                        </div>
                        <div class="col-4">
                            <input type="number" id="searchInput" class="form-control" placeholder="Tahun periode..." name="queryperiode" value="{{ old('queryperiode', date('Y')) }}">
                        </div>
                        <div class="col-2 my-auto">
                            <input type="submit" class="btn button btn-info" value="Cari" style="width: 100%">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                @if (!$pelatihans->isEmpty())
                    @foreach ($pelatihans as $pelatihan)
                    <div class="col-12">
                        <div class="card widget widget-popular-blog">
                            <div class="card-body">
                                <span class="badge badge-style-light rounded-pill badge-success float-end">Selesai</span>
                                <div class="widget-popular-blog-container">
                                    <div class="widget-popular-blog-image">
                                        <img src="{{ asset('assets/images/bidang_pelatihan/' . $pelatihan->bidang_pelatihan->gambar) }}" alt="{{ $pelatihan->nama }}">
                                    </div>
                                    <div class="widget-popular-blog-content ps-4">
                                        <span class="widget-popular-blog-title">
                                            {{ $pelatihan->nama }}
                                        </span>
                                        <span class="widget-popular-blog-title text-black-50">
                                            <i class="material-icons" style="vertical-align: middle">schedule</i>
                                            {{ rentang_tgl($pelatihan->tanggal_mulai, $pelatihan->tanggal_selesai) }}
                                    </span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="/pelatihan/cek-status/{{ $pelatihan->id }}" class="btn btn-primary btn-sm float-end">Cek Status</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card widget widget-popular-blog">
                            <div class="card-body text-center">
                                <h5 style="color:#8b8e95">Belum ada pelatihan yang selesai</h5>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/select2.js') }}"></script>
<script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/pages/datepickers.js') }}"></script>
@endsection


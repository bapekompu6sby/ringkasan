@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
                <div class="card">
                    <div class="card-body">
                        <div class="page-description d-flex align-items-center">
                            <div class="page-description-content flex-grow-1">
                                <h4 style="color:#357097;font-weight: 700;"><u>{{ $noTHP }}. {{ $tahapan->judul }}</u></h4>
                            </div>
                            <div class="page-description-actions">
                                <span class="badge badge-style-bordered badge-info">{{ $pelatihan->nama }}</span>
                            </div>
                        </div>
                        <div class="settings-integrations">
                            @foreach ($kegiatanTahapan as $kegiatan)
                                <div class="settings-integrations-item">
                                    <div class="settings-integrations-item-info">
                                        <h5 style="color:#1b384c; ">{{ $kegiatan->dokumen }}</h5>
                                    </div>
                                    <div class="settings-integrations-item-switcher">
                                        @if ($badge->contains($kegiatan->id))
                                            <span class="badge badge-success text-large">Selesai</span>
                                        @else
                                            @if ($kegiatan->aksi == "Membuat")
                                                <a type="button" class="btn btn-primary btn-small" href="/form-dokumen-pelatihan-{{ $pelatihan->id }}/{{ $kegiatan->id }}-create">
                                                    <i class="uil uil-edit"></i> Buat
                                                </a>
                                                <a type="button" class="btn btn-primary btn-small" href="/form-dokumen-pelatihan-{{ $pelatihan->id }}/{{ $kegiatan->id }}-upload">
                                                    <i class="uil uil-upload"></i> Upload
                                                </a>
                                            @else
                                                <a type="button" class="btn btn-primary btn-small" href="/form-dokumen-pelatihan-{{ $pelatihan->id }}/{{ $kegiatan->id }}-upload">
                                                    <i class="uil uil-upload"></i> Upload 
                                                </a>
                                            @endif
                                            
                                        @endif
                                        
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/js/pages/settings.js')}}"></script>
@endsection

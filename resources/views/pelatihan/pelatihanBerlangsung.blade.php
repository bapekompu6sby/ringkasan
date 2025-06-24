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
            {{-- <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Pelatihan Sedang Berlangsung</h1>
                    </div>
                </div>
            </div> --}}
            <div class="row mb-3">
                <form action="/pelatihan-berlangsung">
                    <div class="row">
                        <div class="col-10">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Pelatihan..." name="querypelatihan" value="{{ (isset($querypelatihan)) ? $querypelatihan : '' }}">
                        </div>
                        <div class="col-2 my-auto">
                            <input style="width: 100%" type="submit" class="btn button btn-info" value="Cari">
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
                                    @can('admin')
                                    <a onclick="hapus_button_{{ $pelatihan->id }}();" class="btn btn-danger btn-sm m-1 float-end"><i class="material-icons-outlined">delete</i></a>
                                    <a onclick="arsip_button_{{ $pelatihan->id }}();" class="btn btn-warning btn-sm m-1 float-end"><i class="material-icons-outlined">archive</i></a>
                                    @endcan
                                    
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
                                    <br>
                                    <div class="widget-popular-blog-container">
                                        <span>
                                            <b>Jenis pelatihan: </b>{{ $pelatihan->jenis_pelatihan->nama }}
                                        </span>
                                    </div>
                                    <div class="widget-popular-blog-container">
                                        <span class="">
                                            <b>Bidang pelatihan: </b>{{ $pelatihan->bidang_pelatihan->nama }}
                                        </span>
                                    </div>
                                    <div class="widget-popular-blog-container">
                                        <span class="">
                                            <b>Model pelatihan: </b>{{ $pelatihan->model_pelatihan->nama }}
                                        </span>
                                    </div>
                                    <br>

                                    @php
                                        $no = 1;
                                    @endphp
                                    

                                    <div class="main-timeline">
                                        <ul class="ul-timeline">
                                            @foreach ($tahapans as $tahapan)
                                                @if ($no == 1)
                                                    <li class="li-timeline">
                                                        <i class="material-icons-outlined icon-timeline uil-timeline">{{ $tahapan->icon}}</i>
                                                        @if ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'yes')
                                                            <a href="/dokumen-pelatihan-{{ $pelatihan->id }}/{{ $no }}/tahapan-{{ $tahapan->id }}" type="button" class="progress-timeline first-timeline active" style="background-color:#20aa6c">
                                                                <i class="material-icons">check</i>
                                                        @elseif ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'process')
                                                            <a href="/dokumen-pelatihan-{{ $pelatihan->id }}/{{ $no }}/tahapan-{{ $tahapan->id }}" type="button" class="progress-timeline first-timeline active" style="background-color:#0d6efd">
                                                                <i class="material-icons">sync</i>
                                                        @else
                                                            <a href="/dokumen-pelatihan-{{ $pelatihan->id }}/{{ $no }}/tahapan-{{ $tahapan->id }}" type="button" class="progress-timeline first-timeline" style="background-color:#7e848d">
                                                                <p class="p-timeline">{{ $no }}</p>
                                                        @endif
                                                            </a>
                                                            {{-- <i class="uil-timeline uil-check"></i> --}}
                                                        <p class="text-timeline">{{ $tahapan->judul }}</p>
                                                    </li>
                                                @else
                                                <li class="li-timeline">
                                                    <i class="material-icons-outlined icon-timeline uil-timeline">{{ $tahapan->icon}}</i>
                                                    @if ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'yes')
                                                        <a href="/dokumen-pelatihan-{{ $pelatihan->id }}/{{ $no }}/tahapan-{{ $tahapan->id }}" type="button" class="progress-timeline {{ $tahapan->id }}-timeline active" style="background-color:#20aa6c">
                                                            <i class="material-icons">check</i>
                                                    @elseif ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'process')
                                                        <a href="/dokumen-pelatihan-{{ $pelatihan->id }}/{{ $no }}/tahapan-{{ $tahapan->id }}" type="button" class="progress-timeline {{ $tahapan->id }}-timeline active" style="background-color:#0d6efd">
                                                            <i class="material-icons">sync</i>
                                                    @else
                                                        <a href="/dokumen-pelatihan-{{ $pelatihan->id }}/{{ $no }}/tahapan-{{ $tahapan->id }}" type="button" class="progress-timeline {{ $tahapan->id }}-timeline" style="background-color:#7e848d">
                                                            <p class="p-timeline">{{ $no }}</p>
                                                    @endif
                                                            {{-- <i class="uil-timeline uil-check"></i> --}}
                                                        </a>
                                                    <p class="text-timeline">{{ $tahapan->judul }}</p>
                                                </li>
                                                @endif
                                                
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <script>
                                        function arsip_button_{{ $pelatihan->id }}() {
                                            Swal.fire({
                                            title: "Konfirmasi Pengarsipan",
                                            text: "Apakah Anda yakin ingin menetapkan pelatihan ini sebagai selesai? ",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonText: "Batal",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Arsip"
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "/pelatihan/arsip/{{ $pelatihan->id }}";
                                            }
                                            });
                                        }
                                        function hapus_button_{{ $pelatihan->id }}() {
                                            Swal.fire({
                                            title: "Konfirmasi Penghapusan",
                                            text: "Apakah Anda yakin ingin menghapus data ini? ",
                                            icon: "warning",
                                            showCancelButton: true,
                                            confirmButtonColor: "#3085d6",
                                            cancelButtonText: "Batal",
                                            cancelButtonColor: "#d33",
                                            confirmButtonText: "Hapus"
                                            }).then((result) => {
                                            if (result.isConfirmed) {
                                                window.location.href = "/pelatihan/hapus/{{ $pelatihan->id }}";
                                            }
                                            });
                                        }
                                    </script>
                                    {{-- @if (Auth::check())
                                        <a href="/pelatihan/kelola-status/{{ $pelatihan->id }}" class="btn btn-primary btn-sm float-end">Kelola Status</a>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="card widget widget-popular-blog">
                            <div class="card-body text-center">
                                <h5 style="color:#8b8e95">Belum ada pelatihan yang berlangsung</h5>
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
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk fitur pencarian
        $('#searchInput').select2({
            placeholder: "Cari Pelatihan...",
            allowClear: true
        });
    });
</script>
{{-- <script>
    function cariPelatihan() {
        var keyword = document.getElementById('searchInput').value.toLowerCase();
        var pelatihanCards = document.getElementsByClassName('card widget widget-popular-blog');
    
        for (var i = 0; i < pelatihanCards.length; i++) {
            var cardContent = pelatihanCards[i].querySelector('.widget-popular-blog-content');
            var pelatihanText = cardContent.innerText.toLowerCase();
            
            if (pelatihanText.includes(keyword)) {
                pelatihanCards[i].style.display = 'block'; // Menampilkan card jika keyword cocok
            } else {
                pelatihanCards[i].style.display = 'none'; // Menyembunyikan card jika keyword tidak cocok
            }
        }
    }
    </script>   --}}
@endsection

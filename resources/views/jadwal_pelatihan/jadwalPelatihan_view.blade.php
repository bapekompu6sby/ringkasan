@extends('layout.navbar')

@section('style')
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
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Detil Jadwal Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <div class="settings-security-two-factor">
                                    <p><b>Nama Pelatihan:</b> {{ $pelatihan->nama }}</p>
                                    <p><b>Jenis Pelatihan:</b> {{ $pelatihan->jenis_pelatihan->nama}}</p>
                                    <p><b>Bidang Pelatihan:</b> {{ $pelatihan->bidang_pelatihan->nama}}</p>
                                    <p><b>Model Pelatihan:</b> {{ $pelatihan->model_pelatihan->nama}}</p>
                                    <p><b>Tanggal Pelaksanaan:</b> {{ rentang_tgl($pelatihan->tanggal_mulai,$pelatihan->tanggal_selesai)}}</p>
                                </div>
                                <br>
                                <a onclick="edit_button();" class="btn btn-warning btn-sm float-end"><i class="material-icons-outlined center" sty>edit</i></a> 
                            </div>
                            <script>
                                function edit_button() {
                                    Swal.fire({
                                    title: "Konfirmasi Pengeditan",
                                    text: "Apakah Anda yakin ingin mengubah jadwal pelatihan ini? ",
                                    icon: "warning",
                                    showCancelButton: true,
                                    confirmButtonColor: "#3085d6",
                                    cancelButtonText: "Batal",
                                    cancelButtonColor: "#d33",
                                    confirmButtonText: "Edit"
                                    }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = "/jadwal-pelatihan/edit/{{ $pelatihan->id }}";
                                    }
                                    });
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
@endsection

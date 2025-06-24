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
            {{-- <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Jadwal Pelatihan</h1>
                    </div>
                </div>
            </div> --}}

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        {{-- <h4><u>Jadwal Pelatihan</u></h4> --}}
                        <div class="row">
                            @can('admin')
                                <div class="col">
                                    <a href="/jadwal-pelatihan/tambah" class="btn btn-primary btn-sm float-end mb-5"><i class="material-icons-outlined">add</i> Tambah Jadwal Pelatihan</a>
                                </div>
                            @endcan
                        </div>
                        <div class="row">
                        <table id="datatable1" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelatihan</th>
                                    <th>Bidang Pelatihan</th>
                                    <th>Tanggal</th>
                                    @can('admin')
                                        <th>Action</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $jadwal->nama }}</td>
                                    <td>{{ $jadwal->bidang_pelatihan->nama }}</td>
                                    <td>{{ rentang_tgl($jadwal->tanggal_mulai, $jadwal->tanggal_selesai) }}</td>
                                    @can('admin')
                                    <td>
                                        <script>
                                            function mulai_button_{{ $jadwal->id }}() {
                                                Swal.fire({
                                                title: "Konfirmasi Pelaksanaan",
                                                text: "Apakah Anda yakin ingin memulai pelatihan ini? ",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonText: "Batal",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Mulai"
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "/jadwal-pelatihan/mulai/{{ $jadwal->id }}";
                                                }
                                                });
                                            }
                                            function view_button_{{ $jadwal->id }}() {

                                                window.location.href = "/jadwal-pelatihan/detil/{{ $jadwal->id }}";
                                            }
                                            
                                            function hapus_button_{{ $jadwal->id }}() {
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
                                                    window.location.href = "/jadwal-pelatihan/hapus/{{ $jadwal->id }}";
                                                }
                                                });
                                            }
                                        </script>
                                        <a onclick="mulai_button_{{ $jadwal->id }}();" class="btn btn-primary btn-sm mt-1"><i class="material-icons-outlined center" sty>add_box</i></a> 
                                        <a onclick="view_button_{{ $jadwal->id }}();" class="btn btn-warning btn-sm mt-1"><i class="material-icons-outlined center" sty>visibility</i></a> 
                                        <a onclick="hapus_button_{{ $jadwal->id }}();" class="btn btn-danger btn-sm mt-1"><i class="material-icons-outlined center" sty>delete</i></a>
                                    </td>
                                    @endcan
                                </tr>
                                @php
                                    $no++;
                                @endphp
                                @endforeach
                            </tbody>
                        </table>
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


@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Kelola Data Jenis Pelatihan</h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="/kelola-jenis-pelatihan/tambah" class="btn btn-primary btn-sm float-end mb-5"><i class="material-icons-outlined">add</i> Tambah Jenis Pelatihan</a>
                            </div>
                        <div class="row">
                        <table id="datatable1" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Jenis</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($jeniss as $jenis)
                                <tr>
                                    <td>{{ $no }}</td>
                                    <td>{{ $jenis->nama }}</td>
                                    <td>
                                        <script>
                                            function edit_button_{{ $jenis->id }}() {
                                                Swal.fire({
                                                title: "Konfirmasi Pengeditan",
                                                text: "Apakah Anda yakin ingin mengubah data ini? ",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonText: "Batal",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Edit"
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "/kelola-jenis-pelatihan/edit/{{ $jenis->id }}";
                                                }
                                                });
                                            }
                                            function hapus_button_{{ $jenis->id }}() {
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
                                                    window.location.href = "/kelola-jenis-pelatihan/hapus/{{ $jenis->id }}";
                                                }
                                                });
                                            }
                                        </script>
                                        <a onclick="edit_button_{{ $jenis->id }}();" class="btn btn-warning btn-sm"><i class="material-icons-outlined center" sty>edit</i></a> 
                                        <a onclick="hapus_button_{{ $jenis->id }}();" class="btn btn-danger btn-sm"><i class="material-icons-outlined center" sty>delete</i></a>
                                    </td>
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


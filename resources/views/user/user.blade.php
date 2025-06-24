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
                        <h1>Kelola Data Pengguna</h1>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <a href="/kelola-pengguna/tambah" class="btn btn-primary btn-sm float-end mb-5"><i class="material-icons-outlined">add</i> Tambah Pengguna</a>
                            </div>
                        <div class="row">
                        <table id="datatable1" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $user->nip }}</td>
                                    <td>{{ $user->nama_lengkap }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <script>
                                            function edit_button_{{ $user->id }}() {
                                                Swal.fire({
                                                title: "Konfirmasi Perubahan",
                                                text: "Apakah Anda yakin ingin melakukan perubahan pada data ini? ",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonText: "Batal",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Edit"
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "/kelola-pengguna/edit/{{ $user->id }}";
                                                }
                                                });
                                            }
                                            function reset_button_{{ $user->id }}() {
                                                Swal.fire({
                                                title: "Konfirmasi Perubahan Password",
                                                text: "Apakah Anda yakin ingin melakukan perubahan password data ini? ",
                                                icon: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: "#3085d6",
                                                cancelButtonText: "Batal",
                                                cancelButtonColor: "#d33",
                                                confirmButtonText: "Edit"
                                                }).then((result) => {
                                                if (result.isConfirmed) {
                                                    window.location.href = "/kelola-pengguna/reset-password/{{ $user->id }}";
                                                }
                                                });
                                            }
                                            function hapus_button_{{ $user->id }}() {
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
                                                    window.location.href = "/kelola-pengguna/hapus/{{ $user->id }}";
                                                }
                                                });
                                            }
                                        </script>
                                        <a onclick="edit_button_{{ $user->id }}();" class="btn btn-primary btn-sm"><i class="material-icons-outlined center" sty>edit</i></a> 
                                        <a onclick="reset_button_{{ $user->id }}();" class="btn btn-warning btn-sm"><i class="material-icons-outlined center" sty>lock_reset</i></a> 
                                        <a onclick="hapus_button_{{ $user->id }}();" class="btn btn-danger btn-sm"><i class="material-icons-outlined center" sty>delete</i></a>
                                    </td>
                                </tr>
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


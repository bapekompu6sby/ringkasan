@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Tambah Pengguna</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/kelola-pengguna/tambah" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nip_user" class="form-label">NIP</label>
                                        <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip_user" name="nip" value="{{ old('nip') }}">
                                        <div class="invalid-feedback">
                                            @error('nip')
                                                NIP harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="nama_lengkap_user" class="form-label">Nama Lengkap</label>
                                        <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap_user" name="nama_lengkap" value="{{ old('nama_lengkap') }}">
                                        <div class="invalid-feedback">
                                            @error('nama_lengkap')
                                                Nama lengkap harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="role_user" class="form-label">Role</label>
                                        <select class="js-states form-control @error('role') is-invalid @enderror" id="role_user" tabindex="-1" style="display:none;width: 100%" name="role">
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="supervisi" {{ old('role') == 'supervisi' ? 'selected' : '' }}>Supervisi</option>
                                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('role')
                                                Role harus dipilih
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="password_user" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password_user" name="password">
                                        <div class="invalid-feedback">
                                            @error('password')
                                                Password harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-primary float-end" type="submit">Tambah</button>
                                    </div>
                                </form>
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
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/select2.js') }}"></script>
@endsection

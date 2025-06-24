@extends('layout.navbar')

@section('style')
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Tambah SOP Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/sop-pelatihan/tambah" method="POST">
                                    @csrf
                                    <h5><u>SOP Pelatihan</u></h5>
                                    <div class="mb-4">
                                        <label for="nomor_sop" class="form-label">Nomor SOP</label>
                                        <input type="text" class="form-control" id="nomor_sop" name="id">
                                    <div class="mb-4">
                                        <label for="judul_sop" class="form-label">Judul SOP</label>
                                        <input type="text" class="form-control" id="judul_sop" name="sop">
                                    </div>
                                    <div class="mb-4">
                                        <label for="icon_sop" class="form-label">Ikon SOP</label>
                                        <input type="text" class="form-control" id="icon_sop" name="icon">
                                    </div>
                                    <h5><u>Kegiatan Pelatihan</u></h5>
                                    <div class="mb-4">
                                        <label for="kegiatan_sop" class="form-label">Nama kegiatan</label>
                                        <input type="text" class="form-control" id="kegiatan_sop" name="kegiatan">
                                    </div>
                                    <div class="mb-4">
                                        <label for="deskrip_sop" class="form-label">Deskripsi Kegiatan</label>
                                        <input type="text" class="form-control" id="deskripsi_sop" name="deskripsi">
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-success float-end" type="submit">Tambah</button>
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
@endsection

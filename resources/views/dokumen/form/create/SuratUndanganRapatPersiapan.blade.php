@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1 class="mb-2">{{ $kegiatan->dokumen }}</h1>
                        <h5 class="text-muted">Pelatihan {{ $pelatihan->nama }}</h5>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                
                                <form action="{{ route('create-'. $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}">
                                        <div class="invalid-feedback">
                                            @error('nomor_surat')
                                                Nomor surat harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <h6>Menindaklanjuti:</h6>
                                    <div class="mb-4">
                                        <label for="surat_perintah" class="form-label">Surat Perintah</label>
                                        <input type="text" class="form-control @error('surat_perintah') is-invalid @enderror" id="surat_perintah" name="surat_perintah" value="{{ old('surat_perintah') }}">
                                        <div class="invalid-feedback">
                                            @error('surat_perintah')
                                                Surat perintah harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="nomor_surat_perintah" class="form-label">Nomor Surat Perintah</label>
                                            <input type="text" class="form-control @error('nomor_surat_perintah') is-invalid @enderror" id="nomor_surat_perintah" name="nomor_surat_perintah" value="{{ old('nomor_surat_perintah') }}">
                                            <div class="invalid-feedback">
                                                @error('nomor_surat_perintah')
                                                    Nomor surat perintah harus diisi
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="tanggal_surat_perintah" class="form-label">Tanggal Surat Perintah</label>
                                            <input id="tanggal_surat_perintah" class="form-control @error('tanggal_surat_perintah') is-invalid @enderror flatpickr1" type="text" placeholder="Pilih tanggal.." name="tanggal_surat_perintah" value="{{ old('tanggal_surat_perintah') }}">
                                            <div class="invalid-feedback">
                                                @error('tanggal_surat_perintah')
                                                    Tanggal surat perintah harus diisi
                                                @enderror
                                            </div>
                                        </div> 
                                    </div>
                                    <br>
                                    <div class="mb-4">
                                        <label for="hal_surat_perintah" class="form-label">Hal</label>
                                        <input type="text" class="form-control @error('hal_surat_perintah') is-invalid @enderror" id="hal_surat_perintah" name="hal_surat_perintah" value="{{ old('hal_surat_perintah') }}">
                                        <div class="invalid-feedback">
                                            @error('hal_surat_perintah')
                                                Hal surat perintah harus diisi
                                            @enderror
                                        </div>
                                    </div>                                                               
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
                                            <input id="tanggal" class="form-control @error('tanggal') is-invalid @enderror flatpickr1" type="text" placeholder="Pilih tanggal.." name="tanggal" value="{{ old('tanggal') }}">
                                            <div class="invalid-feedback">
                                                @error('tanggal')
                                                    Tanggal pelaksanaan harus diisi
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                            <input id="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}">
                                            <div class="invalid-feedback">
                                                @error('waktu_mulai')
                                                    Waktu mulai rapat harus diisi
                                                @enderror
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="zoom_id" class="form-label">Zoom Meeting ID</label>
                                            <input type="text" class="form-control @error('zoom_id') is-invalid @enderror" id="zoom_id" name="zoom_id" value="{{ old('zoom_id') }}">
                                            <div class="invalid-feedback">
                                                @error('zoom_id')
                                                    Zoom Meeting ID harus diisi
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="passcode" class="form-label">Passcode</label>
                                            <input type="text" class="form-control @error('passcode') is-invalid @enderror" id="passcode" name="passcode" value="{{ old('passcode') }}">
                                            <div class="invalid-feedback">
                                                @error('passcode')
                                                    Passcode Zoom harus diisi
                                                @enderror
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    <div class="mb-4">
                                        <label for="req_udRapat" class="form-label">Upload Requirement</label>
                                        <input type="file" class="form-control @error('req_udRapat') is-invalid @enderror" id="req_udRapat" name="req_udRapat" accept=".xls, .xlsx" value="{{ old('req_udRapat') }}">
                                        <div class="invalid-feedback">
                                            @error('req_udRapat')
                                                Requirement harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <p>Download requirement berikut untuk mengisi requirement diatas: 
                                        <a href="{{ route('download-requirement', ['file' => 'req_suratUndanganRapatPersiapan']) }}">Unduh requirement</a>
                                    </p>
                                    <br>
                                    <div class="mb-4">
                                        <button class="btn btn-success float-end" type="submit">Cetak surat</button>
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
<script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/pages/datepickers.js') }}"></script>
@endsection
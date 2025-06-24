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
                                <form action="{{ route('create-'. $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="POST" enctype="multipart/form-data" id="form_pembukaan">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="tanggal" class="form-label">Tanggal Pelaksanaan</label>
                                        <input id="tanggal" class="form-control @error('tanggal') is-invalid @enderror flatpickr1" type="text" placeholder="Pilih tanggal.." name="tanggal" value="{{ old('tanggal') }}">
                                        <div class="invalid-feedback">
                                            @error('tanggal')
                                                Tanggal pelaksanaan harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="kepala_bpsdm" class="form-label">Nama Plt. Kepala Badan Pengembangan SDM</label>
                                        <input type="text" class="form-control @error('kepala_bpsdm') is-invalid @enderror" id="kepala_bpsdm" name="kepala_bpsdm" value="{{ old('kepala_bpsdm') }}">
                                        <div class="invalid-feedback">
                                            @error('kepala_bpsdm')
                                                Nama Plt. Kepala Badan Pengembangan SDM harus diisi
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <label for="tujuan">Tujuan</label>
                                            <textarea class="form-control @error('tujuan') is-invalid @enderror" id="tujuan" form="form_pembukaan" rows="5" name="tujuan" value="{{ old('tujuan') }}"></textarea>
                                            <div class="invalid-feedback">
                                                @error('tujuan')
                                                    Tujuan harus diisi
                                                @enderror
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="mb-4">
                                        <label for="req_laporanPembukaan" class="form-label">Upload Requirement</label>
                                        <input type="file" class="form-control @error('req_laporanPembukaan') is-invalid @enderror" id="req_laporanPembukaan" name="req_laporanPembukaan" accept=".xls, .xlsx" value="{{ old('req_laporanPembukaan') }}">
                                        <div class="invalid-feedback">
                                            @error('req_laporanPembukaan')
                                                Requirement harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <p>Download requirement berikut untuk mengisi requirement diatas: 
                                        <a href="{{ route('download-requirement', ['file' => 'req_laporanPembukaan']) }}">Unduh requirement</a>
                                    </p>
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <label for="pantun">Pantun Penutup</label>
                                            <textarea class="form-control @error('pantun') is-invalid @enderror" id="pantun" form="form_pembukaan" rows="4" name="pantun" value="{{ old('pantun') }}"></textarea>
                                            <div class="invalid-feedback">
                                                @error('pantun')
                                                    Pantun penutup harus diisi
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
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

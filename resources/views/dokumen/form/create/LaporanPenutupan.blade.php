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
                                <form action="{{ route('create-'. $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="POST" enctype="multipart/form-data" id="form_penutupan">
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
                                        <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                                        <input type="text" class="form-control @error('jumlah_peserta') is-invalid @enderror" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}">
                                        <div class="invalid-feedback">
                                            @error('jumlah_peserta')
                                                Jumlah peserta harus diisi
                                            @enderror
                                        </div>
                                    </div>                                    
                                    <div class="mb-4">
                                        <label for="jumlah_peserta_hadir" class="form-label">Jumlah Peserta yang Hadir</label>
                                        <input type="text" class="form-control @error('jumlah_peserta_hadir') is-invalid @enderror" id="jumlah_peserta_hadir" name="jumlah_peserta_hadir" value="{{ old('jumlah_peserta_hadir') }}">
                                        <div class="invalid-feedback">
                                            @error('jumlah_peserta_hadir')
                                                Jumlah peserta yang hadir harus diisi
                                            @enderror
                                        </div>
                                    </div>                                                                        
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="peserta_male" class="form-label">Laki-laki</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control @error('peserta_male') is-invalid @enderror" id="peserta_male" name="peserta_male" aria-describedby="basic-addon2" value="{{ old('peserta_male') }}">
                                                <span class="input-group-text" id="basic-addon2">orang</span>
                                                <div class="invalid-feedback">
                                                    @error('peserta_male')
                                                        Jumlah peserta laki-laki yang hadir harus diisi
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="peserta_female" class="form-label">Perempuan</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control @error('peserta_female') is-invalid @enderror" id="peserta_female" name="peserta_female" aria-describedby="basic-addon2" value="{{ old('peserta_female') }}">
                                                <span class="input-group-text" id="basic-addon2">orang</span>
                                                <div class="invalid-feedback">
                                                    @error('peserta_female')
                                                        Jumlah peserta perempuan yang hadir harus diisi
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    
                                    <div class="mb-4">
                                        <label for="req_laporanPenutupan" class="form-label">Upload Requirement</label>
                                        <input type="file" class="form-control @error('req_laporanPenutupan') is-invalid @enderror" id="req_laporanPenutupan" name="req_laporanPenutupan" accept=".xls, .xlsx" value="{{ old('req_laporanPenutupan') }}">
                                        <div class="invalid-feedback">
                                            @error('req_laporanPenutupan')
                                                Requirement harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <p>Download requirement berikut untuk mengisi requirement diatas: 
                                        @if ($pelatihan->model_pelatihan->id == 'MP001')
                                            <a href="{{ route('download-requirement', ['file' => 'req_laporanPenutupan_MP001']) }}">Unduh requirement</a>
                                        @elseif($pelatihan->model_pelatihan->id == 'MP002')
                                            <a href="{{ route('download-requirement', ['file' => 'req_laporanPenutupan_MP002']) }}">Unduh requirement</a>
                                        @elseif($pelatihan->model_pelatihan->id == 'MP003')
                                            <a href="{{ route('download-requirement', ['file' => 'req_laporanPenutupan_MP003']) }}">Unduh requirement</a>
                                        @endif
                                    </p>
                                    <br>
                                    <div class="mb-4">
                                        <div class="form-group">
                                            <label for="pantun">Pantun Penutup</label>
                                            <textarea class="form-control @error('pantun') is-invalid @enderror" id="pantun" form="form_penutupan" rows="4" name="pantun" value="{{ old('pantun') }}"></textarea>
                                            <div class="invalid-feedback">
                                                @error('pantun')
                                                    Pantun penutup harus diisi
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
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

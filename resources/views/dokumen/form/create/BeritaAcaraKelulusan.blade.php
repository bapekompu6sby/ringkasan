@extends('layout.navbar')

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
                                <form action="{{ route('create-'. $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="post" enctype="multipart/form-data">
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
                                    <h6>Berdasarkan hasil rapat evaluasi kelulusan:</h6>
                                    <div class="mb-4">
                                        <label for="jumlah_peserta" class="form-label">Jumlah Peserta</label>
                                        <input type="text" class="form-control @error('jumlah_peserta') is-invalid @enderror" id="jumlah_peserta" name="jumlah_peserta" value="{{ old('jumlah_peserta') }}">
                                        <div class="invalid-feedback">
                                            @error('jumlah_peserta')
                                                Jumlah peserta harus diisi
                                            @enderror
                                        </div>
                                    </div> 
                                    <h6>Peserta lulus dengan predikat:</h6>
                                    <div class="row">
                                        <div class="col-4">
                                            <label for="memuaskan" class="form-label">Memuaskan</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control @error('memuaskan') is-invalid @enderror" id="memuaskan" name="memuaskan" aria-describedby="basic-addon2" value="{{ old('memuaskan') }}">
                                                <span class="input-group-text" id="basic-addon2">orang</span>
                                                <div class="invalid-feedback">
                                                    @error('memuaskan')
                                                        Jumlah peserta yang lulus dengan predikat Memuaskan harus diisi
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label for="baik_sekali" class="form-label">Baik Sekali</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control @error('baik_sekali') is-invalid @enderror" id="baik_sekali" name="baik_sekali" aria-describedby="basic-addon2" value="{{ old('baik_sekali') }}">
                                                <span class="input-group-text" id="basic-addon2">orang</span>
                                                <div class="invalid-feedback">
                                                    @error('baik_sekali')
                                                        Jumlah peserta yang lulus dengan predikat Baik Sekali harus diisi
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <label for="baik" class="form-label">Baik</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control @error('baik') is-invalid @enderror" id="baik" name="baik" aria-describedby="basic-addon2">
                                                <span class="input-group-text" id="basic-addon2" value="{{ old('baik') }}">orang</span>
                                                <div class="invalid-feedback">
                                                    @error('baik')
                                                        Jumlah peserta yang lulus dengan predikat Baik harus diisi
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="mb-4">
                                        <label for="req_BA" class="form-label">Upload Requirement</label>
                                        <input type="file" class="form-control @error('req_BA') is-invalid @enderror" id="req_BA" name="req_BA" accept=".xls, .xlsx" value="{{ old('req_BA') }}">
                                        <div class="invalid-feedback">
                                            @error('req_BA')
                                                Requirement harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <p>Download requirement berikut untuk mengisi requirement diatas: 
                                        <a href="{{ route('download-requirement', ['file' => 'req_beritaAcaraKelulusan']) }}">Unduh requirement</a>
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
@endsection

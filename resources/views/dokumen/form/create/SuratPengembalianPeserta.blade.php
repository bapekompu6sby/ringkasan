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
                                <form action="{{ route('create-'. $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nomor_surat" class="form-label">Nomor Surat</label>
                                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_Surat') }}">
                                        <div class="invalid-feedback">
                                            @error('nomor_surat')
                                                Nomor surat harus diisi
                                            @enderror
                                        </div>
                                    </div> 
                                    <div class="mb-4">
                                        <label for="req_pengembalian" class="form-label">Upload Requirement</label>
                                        <input type="file" class="form-control @error('req_pengembalian') is-invalid @enderror" id="req_pengembalian" name="req_pengembalian" accept=".xls, .xlsx" value="{{ old('req_pengembalian') }}">
                                        <div class="invalid-feedback">
                                            @error('req_pengembalian')
                                                Requirement harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <p>Download requirement berikut untuk mengisi requirement diatas: 
                                        <a href="{{ route('download-requirement', ['file' => 'req_suratPengembalianPeserta']) }}">Unduh requirement</a>
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
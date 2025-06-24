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
                                <form action="{{ route('upload-'. $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="sambutanPembukaanKapus" class="form-label">Upload Sambutan Pembukaan Kepala Pusat</label>
                                        <input type="file" class="form-control @error('sambutanPembukaanKapus') is-invalid @enderror" id="sambutanPembukaanKapus" name="sambutanPembukaanKapus" accept=".docx, .pdf" value="{{ old('sambutanPembukaanKapus') }}">
                                        <div class="invalid-feedback">
                                            @error('sambutanPembukaanKapus')
                                                Dokumen harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <br>
                                    <div class="mb-4">
                                        <button class="btn btn-success float-end" type="submit">Upload dokumen</button>
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

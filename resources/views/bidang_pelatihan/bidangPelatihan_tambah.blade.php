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
                        <h1>Tambah Bidang Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/kelola-bidang-pelatihan/tambah" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nama_bidang" class="form-label">Nama Bidang Pelatihan</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_bidang" name="nama" value="{{ old('nama') }}">
                                        <div class="invalid-feedback">
                                            @error('nama')
                                                Nama bidang pelatihan harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="gambar_bidang" class="form-label">Gambar Bidang Pelatihan (1 : 1)</label>
                                                <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar_bidang" name="gambar">
                                                <div class="invalid-feedback">
                                                    @error('gambar')
                                                        Gambar bidang pelatihan harus diisi
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Preview Foto</label>
                                                <div class="form-group">
                                                    <img id="gambar_load" src="{{ asset('assets/images/blank.png') }}" width="200px" height="200px">
                                                </div>
                                            </div>
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
<script>
    function bacaGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#gambar_load').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#gambar_bidang').change(function() {
        bacaGambar(this);
    });
</script>
@endsection

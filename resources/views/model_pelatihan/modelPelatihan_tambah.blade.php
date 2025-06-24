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
                        <h1>Tambah Model Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/kelola-model-pelatihan/tambah" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nama_model" class="form-label">Nama Model Pelatihan</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_model" name="nama" value="{{ old('nama') }}">
                                        <div class="invalid-feedback">
                                            @error('nama')
                                                Nama model pelatihan harus diisi
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
@endsection

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
                        <h1>Edit Bidang Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/kelola-bidang-pelatihan/edit/{{ $bidang->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nama_bidang" class="form-label">Nama Bidang Pelatihan</label>
                                        <input type="text" class="form-control" id="nama_bidang" name="nama" value="{{ old('nama') ? old('nama') : $bidang->nama }}">
                                    </div>
                                    <div class="mb-4">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label for="gambar_bidang" class="form-label">Gambar Bidang Pelatihan</label>
                                                <input type="file" class="form-control" id="gambar_bidang" name="gambar">
                                            </div>
                                            <div class="col-sm-6">
                                                <label>Preview Foto</label>
                                                <div class="form-group">
                                                    <img id="gambar_load" src="{{ asset('assets/images/bidang_pelatihan/'. $bidang->gambar ) }}" width="200px" height="200px">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-primary float-end" type="submit">Edit</button>
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

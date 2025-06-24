@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Tambah Kegiatan Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/kegiatan-pelatihan/tambah" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="sop_pelatihan" class="form-label">SOP Pelatihan</label>
                                        <select class="js-states form-control" id="sop_pelatihan" tabindex="-1" style="display:none;width: 100%" name="sop" readonly>
                                            @foreach ($sops as $sop)
                                                <option value={{ $sop->id }} {{ $sop->id == $id_sop ? 'selected' : ''  }}>{{ $sop->sop }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-4">
                                        <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                                        <input type="text" class="form-control" id="nama_kegiatan" name="kegiatan">
                                    </div>
                                    <div class="mb-4">
                                        <label for="deskripsi _kegiatan" class="form-label">Deskripsi Kegiatan</label>
                                        <input type="text" class="form-control" id="deskripsi _kegiatan" name="deskripsi">
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
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/select2.js') }}"></script>
@endsection

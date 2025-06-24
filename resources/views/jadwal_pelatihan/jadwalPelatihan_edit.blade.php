@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>Edit Jadwal Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/jadwal-pelatihan/edit/{{ $pelatihan->id }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nama_pelatihan" class="form-label">Nama Pelatihan</label>
                                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama_pelatihan" name="nama" value="{{ old('nama') ? old('nama') :  $pelatihan->nama  }}">
                                        <div class="invalid-feedback">
                                            @error('nama')
                                                Nama pelatihan harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="jenis_pelatihan" class="form-label">Jenis Pelatihan</label>
                                        <select class="js-states form-control @error('id_jenis') is-invalid @enderror" id="jenis_pelatihan" tabindex="-1" style="display:none;width: 100%" name="id_jenis">
                                            @php
                                                if (old('id_jenis')) {
                                                    $pelatihan->id_jenis = old('id_jenis');
                                                }
                                            @endphp
                                            @foreach ($jeniss as $jenis)
                                                <option value="{{ $jenis->id }}" {{ $pelatihan->id_jenis == $jenis->id ? 'selected': '' }}>{{ $jenis->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('id_jenis')
                                                Jenis pelatihan harus dipilih
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="bidang_pelatihan" class="form-label">Bidang Pelatihan</label>
                                        <select class="js-states form-control @error('id_bidang') is-invalid @enderror" id="bidang_pelatihan" tabindex="-1" style="display:none;width: 100%" name="id_bidang">
                                            @php
                                                if (old('id_bidang')) {
                                                    $pelatihan->id_bidang = old('id_bidang');
                                                }
                                            @endphp
                                            @foreach ($bidangs as $bidang)
                                                <option value="{{ $bidang->id }}" {{ $pelatihan->id_bidang == $bidang->id ? 'selected': '' }}>{{ $bidang->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('id_bidang')
                                                Bidang pelatihan harus dipilih
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="model_pelatihan" class="form-label">Model Pelatihan</label>
                                        <select class="js-states form-control @error('id_model') is-invalid @enderror" id="model_pelatihan" tabindex="-1" style="display:none;width: 100%" name="id_model">
                                            @php
                                                if (old('id_model')) {
                                                    $pelatihan->id_model = old('id_model');
                                                }
                                            @endphp
                                            @foreach ($models as $model)
                                                <option value="{{ $model->id }}" {{ $pelatihan->id_model == $model->id ? 'selected': '' }}>{{ $model->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            @error('id_model')
                                                Model pelatihan harus dipilih
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                        <input id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror flatpickr1" type="text" placeholder="Select Date.." name="tanggal_mulai" value="{{ old('tanggal_mulai') ? old('tanggal_mulai') :  $pelatihan->tanggal_mulai  }}">
                                        <div class="invalid-feedback">
                                            @error('tanggal_mulai')
                                                Tanggal mulai harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                        <input id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror flatpickr1" type="text" placeholder="Select Date.." name="tanggal_selesai" value="{{ old('tanggal_selesai') ? old('tanggal_selesai') :  $pelatihan->tanggal_selesai  }}">
                                        <div class="invalid-feedback">
                                            @error('tanggal_selesai')
                                                Tanggal selesai harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="tahun_periode" class="form-label">Tahun Periode</label>
                                        <input id="tahun_periode" class="form-control @error('tahun_periode') is-invalid @enderror" type="number" name="tahun_periode" value="{{ old('tahun_periode') ? old('tahun_periode') :  $pelatihan->tahun_periode  }}">
                                        <div class="invalid-feedback">
                                            @error('tahun_periode')
                                                Tahun periode harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-success float-end m-2" type="submit">Edit</button>
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
<script src="{{ asset('assets/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('assets/js/pages/datepickers.js') }}"></script>
@endsection

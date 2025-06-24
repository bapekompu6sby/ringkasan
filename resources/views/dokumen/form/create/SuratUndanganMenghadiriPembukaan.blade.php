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
                                        <input type="text" class="form-control @error('nomor_surat') is-invalid @enderror" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}">
                                        <div class="invalid-feedback">
                                            @error('nomor_surat')
                                                Nomor surat harus diisi
                                            @enderror
                                        </div>
                                    </div> 
                                    <h6>Kepada:</h6>
                                    <div class="mb-4">
                                        <div class="form-check">
                                            @if (old('kata_ganti'))
                                                <input class="form-check-input" type="radio" name="kata_ganti" id="bapak" value="Bapak" {{ old('kata_ganti') == 'Bapak' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="bapak">
                                                Bapak
                                            </label>
                                            @else
                                                <input class="form-check-input" type="radio" name="kata_ganti" id="bapak" value="Bapak" checked>
                                            @endif
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="kata_ganti" id="ibu" value="Ibu" {{ old('kata_ganti') == 'Ibu' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="ibu">
                                                Ibu
                                            </label>
                                        </div>
                                        <div class="invalid-feedback">
                                            @error('kata_ganti')
                                                Kata ganti identitas penerima harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="nama_yth" class="form-label">Penerima</label>
                                        <input type="text" class="form-control @error('nama_yth') is-invalid @enderror" id="nama_yth" name="nama_yth" value="{{ old('nama_yth') }}">
                                        <div class="invalid-feedback">
                                            @error('nama_yth')
                                                Penerima harus diisi
                                            @enderror
                                        </div>
                                    </div>                                    
                                    <div class="mb-4">
                                        <label for="lokasi" class="form-label">Lokasi</label>
                                        <input type="text" class="form-control @error('lokasi') is-invalid @enderror" id="lokasi" name="lokasi" value="{{ old('lokasi') }}">
                                        <div class="invalid-feedback">
                                            @error('lokasi')
                                                Lokasi penerima harus diisi
                                            @enderror
                                        </div>
                                    </div>                                    
                                    <div class="mb-4">
                                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                        <input id="waktu_mulai" class="form-control @error('waktu_mulai') is-invalid @enderror" type="time" name="waktu_mulai" value="{{ old('waktu_mulai') }}">
                                        <div class="invalid-feedback">
                                            @error('waktu_mulai')
                                                Waktu mulai pembukaan harus diisi
                                            @enderror
                                        </div>
                                    </div>                                    
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="zoom_id" class="form-label">Zoom Meeting ID</label>
                                            <input type="text" class="form-control @error('zoom_id') is-invalid @enderror" id="zoom_id" name="zoom_id" value="{{ old('zoom_id') }}">
                                            <div class="invalid-feedback">
                                                @error('zoom_id')
                                                    Zoom Meeting ID harus diisi
                                                @enderror
                                            </div>
                                            
                                        </div>
                                        <div class="col-6">
                                            <label for="passcode" class="form-label">Passcode</label>
                                            <input type="text" class="form-control @error('passcode') is-invalid @enderror" id="passcode" name="passcode" value="{{ old('passcode') }}">
                                            <div class="invalid-feedback">
                                                @error('passcode')
                                                    Passcode Zoom harus diisi
                                                @enderror
                                            </div>
                                        </div>  
                                    </div>
                                    <br>
                                    <div class="mb-4">
                                        <label for="req_suratUndanganMenghadiriPembukaan" class="form-label">Upload Requirement</label>
                                        <input type="file" class="form-control @error('req_suratUndanganMenghadiriPembukaan') is-invalid @enderror" id="req_suratUndanganMenghadiriPembukaan" name="req_suratUndanganMenghadiriPembukaan" accept=".xls, .xlsx" value="{{ old('req_suratUndanganMenghadiriPembukaan') }}">
                                        <div class="invalid-feedback">
                                            @error('req_suratUndanganMenghadiriPembukaan')
                                                Requirement harus diisi
                                            @enderror
                                        </div>
                                    </div>
                                    <p>Download requirement berikut untuk mengisi requirement diatas: 
                                        <a href="{{ route('download-requirement', ['file' => 'req_suratUndanganMenghadiriPembukaan']) }}">Unduh requirement</a>
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

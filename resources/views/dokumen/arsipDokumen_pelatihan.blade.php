@extends('layout.navbar')

@section('style')

@endsection

@section('sidebar')
@include('layout.sidebar')
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row mb-3">
                <form action="/arsip-dokumen/pelatihan-{{ $id_pelatihan }}">
                    <div class="row">
                        <div class="col-10">
                            <input type="text" class="form-control" placeholder="Cari dokumen..." name="nama_dokumen" value="{{ (isset($nama_dokumen)) ? $nama_dokumen : '' }}">
                        </div>
                        <div class="col-2 my-auto">
                            <input type="submit" class="btn button btn-info" value="Cari" style="width: 100%">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-12">
                    @if (!$dokumens->isEmpty())
                        @foreach ($dokumens[$id_pelatihan] as $dokumen)
                            <div class="card file-manager-recent-item">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        @php
                                            $split = explode('.', $dokumen->file);
                                            $ext = $split[1]
                                        @endphp
                                        @if ($ext == 'pdf')
                                            <i class="material-icons-outlined text-danger align-middle m-r-sm">description</i>
                                        @elseif($ext == 'doc' || $ext == 'docx')
                                            <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                                        @elseif($ext == 'xlsx' || $ext == 'xls')
                                            <i class="material-icons-outlined text-success align-middle m-r-sm">description</i>
                                        @elseif($ext == 'rar' || $ext == 'zip')
                                            <i class="material-icons-outlined text-info align-middle m-r-sm">description</i>
                                        @endif
                                        {{-- <a href="{{ asset('assets/dokumen/daftar_calon_peserta.xlsx') }}" target="_blank" class="file-manager-recent-item-title flex-fill">{{ $dokumen->kegiatan_tahapan->dokumen }}</a> --}}
                                        <a href="{{ asset('assets/dokumen/'. $dokumen->status->pelatihan->id . '_' .$dokumen->id_kegiatan_tahapan . '.' . $ext) }}" target="_blank" class="file-manager-recent-item-title flex-fill">{{ $dokumen->kegiatan_tahapan->dokumen }}</a>
                                        <span class="p-h-sm text-muted">{{ $dokumen->status->pelatihan->nama }}</span>
                                        <a class="dropdown-toggle file-manager-recent-file-actions" id="file-manager-recent-10" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="file-manager-recent-10">
                                            <li><a class="dropdown-item" href="/arsip-dokumen/unduh-{{ $dokumen->id }}">Unduh</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    @else
                        <div class="card widget widget-popular-blog">
                            <div class="card-body text-center">
                                <h5 style="color:#8b8e95">Belum ada arsip dokumen pelatihan</h5>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection


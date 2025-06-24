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
                <form action="/arsip-dokumen">
                    <div class="row">
                        <div class="col-6">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Pelatihan..." name="querypelatihan" value="{{ (isset($querypelatihan)) ? $querypelatihan : '' }}">
                        </div>
                        <div class="col-4">
                            <input type="number" id="searchInput" class="form-control" placeholder="Tahun periode..." name="queryperiode" value="{{ isset($queryperiode) ? $queryperiode : date('Y') }}">
                        </div>
                        <div class="col-2 my-auto">
                            <input type="submit" class="btn button btn-info" value="Cari" style="width: 100%">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                @if (!$dokumens->isEmpty())
                    @foreach ($dokumens as $dokumen)
                        <div class="col-xl-4">
                            <div class="card file-manager-group">
                                <div class="card-body d-flex align-items-center">
                                    <i class="material-icons text-warning">folder</i>
                                    <div class="file-manager-group-info flex-fill">
                                        <a href="/arsip-dokumen/pelatihan-{{ $dokumen[0]->status->pelatihan->id }}" class="file-manager-group-title">{{ $dokumen[0]->status->pelatihan->nama }}</a>
                                        <span class="file-manager-group-about">{{ $dokumen->count() }} files</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    
                @else
                    <div class="col-12">
                        <div class="card widget widget-popular-blog">
                            <div class="card-body text-center">
                                <h5 style="color:#8b8e95">Belum ada arsip dokumen pelatihan</h5>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection


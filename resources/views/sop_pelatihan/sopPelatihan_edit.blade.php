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
                        <h1>Edit Pelatihan</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="card widget">
                        <div class="card card-body">
                            <div class="widget-stats-container">
                                <form action="/sop-pelatihan/edit/{{ $sop->id }}" method="POST">
                                    @csrf
                                    <div class="mb-4">
                                        <label for="nomor_sop" class="form-label">Nomor SOP</label>
                                        <input type="text" class="form-control" id="nomor_sop" name="id" value="{{ $sop->id }}">
                                    </div>
                                    <div class="mb-4">
                                        <label for="judul_sop" class="form-label">Judul SOP</label>
                                        <input type="text" class="form-control" id="judul_sop" name="sop" value="{{ $sop->sop }}">
                                    </div>
                                    <div class="mb-4">
                                        <button class="btn btn-success float-end" type="submit">Edit</button>
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

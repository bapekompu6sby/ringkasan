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
            <div class="card">
            <div class="card-header">
                <h4 class="card-title
                ">{{ $kegiatan->dokumen }}</h4>
            </div>
            <div class="card-body">
                <div class="row">
                        <embed src="data:application/pdf;base64,{{ base64_encode($pdf_content) }}" type="application/pdf" width="100%" height="600px" />
                        <form action="{{ route('print-' . $nama_fungsi, ['id_pl' => $pelatihan->id, 'id_kthp' => $kegiatan->id]) }}" method="POST">
                            @csrf
                            <input type="hidden" name="pdf_content" value="{{ base64_encode($pdf_content) }}">
                            <button type="submit" class="btn btn-primary btn-sm float-end mt-3">Simpan dan kirim untuk ditinjau</button>
                        </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

@section('script')

@endsection


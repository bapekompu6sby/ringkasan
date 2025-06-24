@extends('layout.navbar')

@section('style')
<link href="{{ asset('assets/plugins/datatables/datatables.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            {{-- <div class="row">
                <div class="col">
                    <div class="page-description">
                        <h1>SOP Pelatihan</h1>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <div class="col">
                    <div class="card todo-container">
                        <div class="row">
                            <div class="col-xl-4 col-xxl-3">
                                <div class="todo-menu">
                                    <h5 class="todo-menu-title">SOP Pengembangan Kompetensi</h5>
                                    <hr>
                                    <br>
                                    <ul class="list-unstyled todo-status-filter nav nav-pills" id="pills-tab" role="tablist">
                                        <?php
                                            $no_sop = 1;
                                        ?>
                                        @foreach ($sopKegiatan as $sop)
                                        {{-- @if ($detil_status->isEmpty()) --}}
                                            @if ($no_sop == 1)
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" id="pills-{{ $sop[0]->sop->id }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $sop[0]['id'] }}" type="button" role="tab" aria-controls="pills-{{ $sop[0]['id'] }}" aria-selected="true">
                                                        <i class="material-icons-outlined">{{ $sop[0]->sop->icon}}</i>{{ $sop[0]->sop->judul}}
                                                    </a>
                                                </li>
                                            @else
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-{{ $sop[0]->sop->id }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $sop[0]['id'] }}" type="button" role="tab" aria-controls="pills-{{ $sop[0]['id'] }}" aria-selected="true">
                                                    <i class="material-icons-outlined">{{ $sop[0]->sop->icon}}</i>{{ $sop[0]->sop->judul}}
                                                </a>
                                            </li>
                                            @endif
                                        {{-- @else
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link" id="pills-{{ $sop[0]->sop->id }}-tab" data-bs-toggle="pill" data-bs-target="#pills-{{ $sop[0]['id'] }}" type="button" role="tab" aria-controls="pills-{{ $sop[0]['id'] }}" aria-selected="true">
                                                    <i class="material-icons-outlined">{{ $sop[0]->sop->icon}}</i>{{ $sop[0]->sop->judul}}
                                                </a>
                                            </li>
                                        @endif --}}
                                        @php
                                            $no_sop++;
                                        @endphp
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-xl-8 col-xxl-9">
                                <div class="todo-list">
                                    @php
                                        $index_kegiatan = 1;
                                    @endphp
                                    <div class="tab-content" id="pills-tabContent">
                                    @php
                                        $last_pills_tab = '';
                                        $last_pills_content = '';
                                    @endphp
                                    @foreach ($sopKegiatan as $kegiatans)
                                    {{-- @if ($detil_status->isEmpty()) --}}
                                        @if ($index_kegiatan == 1)
                                            <ul class="list-unstyled tab-pane fade show active" id="pills-{{ $kegiatans[0]['id'] }}" role="tabpanel" aria-labelledby="pills-{{ $kegiatans[0]['id'] }}-tab">
                                        @else
                                        <ul class="list-unstyled tab-pane fade" id="pills-{{ $kegiatans[0]['id'] }}" role="tabpanel" aria-labelledby="pills-{{ $kegiatans[0]['id'] }}-tab">
                                        @endif
                                    {{-- @else
                                        <ul class="list-unstyled tab-pane fade" id="pills-{{ $kegiatans[0]['id'] }}" role="tabpanel" aria-labelledby="pills-{{ $kegiatans[0]['id'] }}-tab">
                                    @endif --}}
                                        @php
                                            $no_kegiatan = 1;
                                        @endphp
                                        @foreach ($kegiatans as $kegiatan)
                                            <li class="todo-item">
                                                <div class="todo-item-content">
                                                    <span class="todo-item-title">{{ $no_kegiatan . '. '  .$kegiatan->nama }}
                                                    </span>
                                                    <span class="todo-item-subtitle">{{ $kegiatan->deskripsi }}</span>
                                                </div>
                                            </li>
                                        @php
                                            $no_kegiatan++;
                                        @endphp
                                            @endforeach
                                        </ul>
                                    @php
                                        $index_kegiatan++;
                                    @endphp
                                        @endforeach
                                </div>
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
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
@endsection


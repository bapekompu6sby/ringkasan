@extends('layout.navbar')

@section('style')
<link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-container bg-primary">
                            <li class="breadcrumb-item"><a href="/pelatihan-berlangsung">Perlatihan Berlangsung</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Status Pelatihan</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card card-default">
                        <div class="card-header">
                            @auth('admin')
                                <a href="/pelatihan/kelola-status/{{ $pelatihan->id }}" type="button" class="btn btn-primary float-end">Kelola Status</a>
                            @endauth
                            <div class="card-title">
                                <p class="head_1-timeline">Status Pelatihan</p>
                                <p class="head_2-timeline">{{ $pelatihan->nama }}</p>
                            </div>
                        </div>
                        @php
                            $no = 1;
                        @endphp
                        <div class="main-timeline">
                            <ul class="ul-timeline">
                                @foreach ($sops as $sop)
                                    @if ($no == 1)
                                        <li class="li-timeline">
                                            <i class="material-icons-outlined icon-timeline uil-timeline">{{ $sop->icon}}</i>
                                            @if ($status_per_sop[$sop->id] == 'yes')
                                                <div class="progress-timeline first-timeline active">
                                                    <i class="material-icons">check</i>
                                            @elseif ($status_per_sop[$sop->id] == 'process')
                                                <div class="progress-timeline first-timeline active">
                                                    <i class="material-icons">sync</i>
                                            @else
                                                <div class="progress-timeline first-timeline">
                                                    <p class="p-timeline">{{ $no }}</p>
                                            @endif
                                                <i class="uil-timeline uil-check"></i>
                                            </div>
                                            <p class="text-timeline">{{ $sop->judul }}</p>
                                        </li>
                                    @else
                                    <li class="li-timeline">
                                        <i class="material-icons-outlined icon-timeline uil-timeline">{{ $sop->icon}}</i>
                                        @if ($status_per_sop[$sop->id] == 'yes')
                                            <div class="progress-timeline {{ $sop->id }}-timeline active">
                                                <i class="material-icons">check</i>
                                        @elseif ($status_per_sop[$sop->id] == 'process')
                                            <div class="progress-timeline {{ $sop->id }}-timeline active">
                                                <i class="material-icons">sync</i>
                                        @else
                                            <div class="progress-timeline {{ $sop->id }}-timeline">
                                                <p class="p-timeline">{{ $no }}</p>
                                        @endif
                                                <i class="uil-timeline uil-check"></i>
                                            </div>
                                        <p class="text-timeline">{{ $sop->judul }}</p>
                                    </li>
                                    @endif
                                    
                                    @php
                                        $no++;
                                    @endphp
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/js/timeline.js') }}"></script>
@endsection
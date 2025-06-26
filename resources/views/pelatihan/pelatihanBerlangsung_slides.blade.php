<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Ringkasan - Monitoring</title>

     <!-- Styles -->
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap"
    rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
    rel="stylesheet">
  <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/pace/pace.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/highlight/styles/github-gist.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/plugins/flatpickr/flatpickr.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/timeline.css') }}">
<link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


  <!-- Theme Styles -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main_tamu.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

  <link rel="icon" type="image/jpg" sizes="32x32" href="{{ asset('assets/images/logo.jpg') }}" />
  <link rel="icon" type="image/jpg" sizes="16x16" href="{{ asset('assets/images/logo.jpg') }}" />
  
</head>

<body>
@if (!function_exists('tanggal_indo'))
    @php
    function tanggal_indo($tanggal){
        $bulan = array (
        1 =>'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
    }

    function rentang_tgl($tgl_mulai, $tgl_selesai){
        $tgl_mulai = tanggal_indo($tgl_mulai);
        $tgl_selesai = tanggal_indo($tgl_selesai);
        $tgl_mulai_pecah = explode(' ', $tgl_mulai);
        $tgl_selesai_pecah = explode(' ', $tgl_selesai);
        if ($tgl_mulai_pecah[1] == $tgl_selesai_pecah[1]) {
            return $tgl_mulai_pecah[0] . ' s.d ' . $tgl_selesai_pecah[0] . ' ' . $tgl_mulai_pecah[1] . ' ' . $tgl_mulai_pecah[2];
        }
        return $tgl_mulai . ' s.d ' . $tgl_selesai;
    }

    function hari_indo($tanggal){
        if (date('l', strtotime($tanggal)) == 'Sunday') {
            return 'Minggu';
        } elseif (date('l', strtotime($tanggal)) == 'Monday') {
            return 'Senin';
        } elseif (date('l', strtotime($tanggal)) == 'Tuesday') {
            return 'Selasa';
        } elseif (date('l', strtotime($tanggal)) == 'Wednesday') {
            return 'Rabu';
        } elseif (date('l', strtotime($tanggal)) == 'Thursday') {
            return 'Kamis';
        } elseif (date('l', strtotime($tanggal)) == 'Friday') {
            return 'Jumat';
        } elseif (date('l', strtotime($tanggal)) == 'Saturday') {
            return 'Sabtu';
        }
        return date('l', strtotime($tanggal));
    }
    @endphp
@endif
    <div class="app menu-off-canvas align-content-stretch d-flex flex-wrap">
        <div class="app-container">
            <div class="example-container">
                <a href="{{ route('login') }}" class="floating-login-btn"><i class="material-icons" style="vertical-align: middle">login</i> Login</a>
                    <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @foreach ($pelatihans as $pelatihan)
                                @if ($loop->first)
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{ $loop->index }}" class="active" aria-label="Slide {{ $loop->iteration }}" aria-current="true"></button>
                                @else
                                    <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="{{ $loop->index }}" aria-label="Slide {{ $loop->iteration }}" class=""></button>
                                @endif
                            @endforeach
                        </div>
                        <div class="carousel-inner">

                            @foreach ($pelatihans as $pelatihan)
                                @if ($loop->first)
                                    <div class="carousel-item active" data-bs-interval="10000">
                                        <div class="card">
                                            <div class="app-auth-container-slides" style="width: 100%">
                                                <div class="row d-flex justify-content-between">
                                                    <div class="col-md-6">
                                                        <div class="logo">
                                                            <a>Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya</a>
                                                        </div>
                                                        <br>
                                                        <h1 class="badge text-center badge-dark badge-ringkasan mt-auto">RINGKASAN - Monitoring Pelaksanaan Pelatihan</h1>
                                                    </div>
                                                    <ul class="col-md-3 mt-3" style="list-style: none;font-size:0.9em">
                                                        <li><b>Keterangan: </b></li>
                                                        <li><span class="me-3" style="background-color:#7e848d;white-space: pre;">        </span>Belum ada progres</li>
                                                        <li><span class="me-3" style="background-color:#0d6efd;white-space: pre;">        </span>Progres sedang berlangsung</li>
                                                        <li><span class="me-3" style="background-color:#20aa6c;white-space: pre;">        </span>Progres selesai</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            

                                            <div class="main-timeline-slides">
                                                <div class="caption-top-slides text-center mt-3 bg-light text-sm-center">
                                                    <h5>{{ $pelatihan->nama }}</h5>
                                                    <p>{{ $pelatihan->model_pelatihan->nama }}.</p>
                                                    <p class="badge badge-info badge-style-light" style="font-size:0.9rem"><b>{{ rentang_tgl($pelatihan->tanggal_mulai,$pelatihan->tanggal_selesai) }}</b></p>
                                                </div>
                                                <ul class="ul-timeline-slides">
                                                    @foreach ($tahapans as $tahapan)
                                                        @if ($loop->first)
                                                            <li class="li-timeline-slides">
                                                                <i class="material-icons-outlined icon-timeline-slides uil-timeline-slides">{{ $tahapan->icon}}</i>
                                                                @if ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'yes')
                                                                    <a class="progress-timeline-slides first-timeline-slides active" style="background-color:#20aa6c">
                                                                        <i class="material-icons">check</i>
                                                                @elseif ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'process')
                                                                    <a class="progress-timeline-slides first-timeline-slides active" style="background-color:#0d6efd">
                                                                        <i class="material-icons">sync</i>
                                                                @else
                                                                    <a class="progress-timeline-slides first-timeline-slides" style="background-color:#7e848d">
                                                                        <p class="p-timeline-slides">{{ $loop->iteration }}</p>
                                                                @endif
                                                                    </a>
                                                                    {{-- <i class="uil-timeline-slides uil-check"></i> --}}
                                                                <p class="text-timeline-slides">{{ $tahapan->judul }}</p>
                                                            </li>
                                                        @else
                                                        <li class="li-timeline-slides">
                                                            <i class="material-icons-outlined icon-timeline-slides uil-timeline-slides">{{ $tahapan->icon}}</i>
                                                            @if ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'yes')
                                                                <a class="progress-timeline-slides {{ $tahapan->id }}-timeline active" style="background-color:#20aa6c">
                                                                    <i class="material-icons">check</i>
                                                            @elseif ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'process')
                                                                <a class="progress-timeline-slides {{ $tahapan->id }}-timeline active" style="background-color:#0d6efd">
                                                                    <i class="material-icons">sync</i>
                                                            @else
                                                                <a class="progress-timeline-slides {{ $tahapan->id }}-timeline" style="background-color:#7e848d">
                                                                    <p class="p-timeline-slides">{{ $loop->iteration }}</p>
                                                            @endif
                                                                </a>
                                                            <p class="text-timeline-slides">{{ $tahapan->judul }}</p>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                        
                                            <br><br><br><br><br><br>
                                            <div class="carousel-caption d-md-block caption-bottom-slides">
                                                <h5>{{ $pelatihan->nama }}</h5>
                                                <p>{{ $pelatihan->model_pelatihan->nama }}.</p>
                                                <p class="badge badge-info badge-style-light" style="font-size:0.9rem"><b>{{ rentang_tgl($pelatihan->tanggal_mulai,$pelatihan->tanggal_selesai) }}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="carousel-item" data-bs-interval="10000">
                                        <div class="card">
                                            <div class="app-auth-container-slides" style="width: 100%">
                                                    <div class="row d-flex justify-content-between">
                                                        <div class="col-md-6">
                                                            <div class="logo">
                                                                <a>Balai Pengembangan Kompetensi Pekerjaan Umum Wilayah VI Surabaya</a>
                                                            </div>
                                                            <br>
                                                            <h1 class="badge text-center badge-dark badge-ringkasan">RINGKASAN - Monitoring Pelaksanaan</h1>
                                                        </div>
                                                        <ul class="col-md-3 mt-3" style="list-style: none;font-size:0.9em">
                                                            <li><b>Keterangan: </b></li>
                                                            <li><span class="me-3" style="background-color:#7e848d;white-space: pre;">        </span>Belum ada progres</li>
                                                            <li><span class="me-3" style="background-color:#0d6efd;white-space: pre;">        </span>Progres sedang berlangsung</li>
                                                            <li><span class="me-3" style="background-color:#20aa6c;white-space: pre;">        </span>Progres selesai</li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            <div class="main-timeline-slides">
                                                <div class="caption-top-slides text-center mt-3 bg-light text-sm-center">
                                                    <h5>{{ $pelatihan->nama }}</h5>
                                                    <p>{{ $pelatihan->model_pelatihan->nama }}.</p>
                                                    <p class="badge badge-info badge-style-light" style="font-size:0.9rem"><b>{{ rentang_tgl($pelatihan->tanggal_mulai,$pelatihan->tanggal_selesai) }}</b></p>
                                                </div>
                                                <ul class="ul-timeline-slides">
                                                    @foreach ($tahapans as $tahapan)
                                                        @if ($loop->first)
                                                            <li class="li-timeline-slides">
                                                                <i class="material-icons-outlined icon-timeline-slides uil-timeline-slides">{{ $tahapan->icon}}</i>
                                                                @if ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'yes')
                                                                    <a class="progress-timeline-slides first-timeline-slides active" style="background-color:#20aa6c">
                                                                        <i class="material-icons">check</i>
                                                                @elseif ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'process')
                                                                    <a class="progress-timeline-slides first-timeline-slides active" style="background-color:#0d6efd">
                                                                        <i class="material-icons">sync</i>
                                                                @else
                                                                    <a class="progress-timeline-slides first-timeline-slides" style="background-color:#7e848d">
                                                                        <p class="p-timeline-slides">{{ $loop->iteration }}</p>
                                                                @endif
                                                                    </a>
                                                                    {{-- <i class="uil-timeline-slides uil-check"></i> --}}
                                                                <p class="text-timeline-slides">{{ $tahapan->judul }}</p>
                                                            </li>
                                                        @else
                                                        <li class="li-timeline-slides">
                                                            <i class="material-icons-outlined icon-timeline-slides uil-timeline-slides">{{ $tahapan->icon}}</i>
                                                            @if ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'yes')
                                                                <a class="progress-timeline-slides {{ $tahapan->id }}-timeline active" style="background-color:#20aa6c">
                                                                    <i class="material-icons">check</i>
                                                            @elseif ($pelatihan_progres[$pelatihan->id][$tahapan->id] == 'process')
                                                                <a class="progress-timeline-slides {{ $tahapan->id }}-timeline active" style="background-color:#0d6efd">
                                                                    <i class="material-icons">sync</i>
                                                            @else
                                                                <a class="progress-timeline-slides {{ $tahapan->id }}-timeline" style="background-color:#7e848d">
                                                                    <p class="p-timeline-slides">{{ $loop->iteration }}</p>
                                                            @endif
                                                                    {{-- <i class="uil-timeline-slides uil-check"></i> --}}
                                                                </a>
                                                            <p class="text-timeline-slides">{{ $tahapan->judul }}</p>
                                                        </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            {{-- <br><br><br><br><br><br><br> --}}
                                            <br><br><br><br><br><br>
                                            <div class="carousel-caption d-md-block caption-bottom-slides">
                                                <h5>{{ $pelatihan->nama }}</h5>
                                                <p>{{ $pelatihan->model_pelatihan->nama }}.</p>
                                                <p class="badge badge-info badge-style-light" style="font-size:0.9rem"><b>{{ rentang_tgl($pelatihan->tanggal_mulai,$pelatihan->tanggal_selesai) }}</b></p>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endif
                                
                            @endforeach
                            
                        </div>
                        <button style="margin-top: -150px;margin-left:-50px" class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button style="margin-top: -150px;margin-right:-50px" class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    
    <script src="{{ asset('assets/plugins/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/perfectscroll/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/highlight/highlight.pack.js') }}"></script>

    <script src="{{ asset('assets/js/main.min.js') }}"></script>
    <script src="{{ asset('assets/js/main_tammu.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/pages/dashboard.js') }}"></script>
</body>

</html>
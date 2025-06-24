<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="keywords" content="admin,dashboard">
  <meta name="author" content="stacks">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

  <!-- Title -->
  <title>Ringkasan</title>

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

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  @section('style')
  @show

  <!-- Theme Styles -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/main_tamu.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

  <link rel="icon" type="image/jpg" sizes="32x32" href="{{ asset('assets/images/logo.jpg') }}" />
  <link rel="icon" type="image/jpg" sizes="16x16" href="{{ asset('assets/images/logo.jpg') }}" />

  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <div class="app align-content-stretch d-flex flex-wrap">
    @include('layout.sidebar')
    <div class="app-container">
    {{-- <div class="search">
        <form>
          <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
        </form>
        <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
      </div> --}}
      <div class="app-header">
        <nav class="navbar navbar-light navbar-expand-lg">
          <div class="container-fluid">
            <div class="navbar-nav" id="navbarNav">
              <ul class="navbar-nav">
                <li class="nav-item">
                  @if (Auth::check())
                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                  @else
                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                  @endif
                  
                </li>
                @can('admin')
                <li class="nav-item dropdown hidden-on-mobile">
                  <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="material-icons">apps</i>
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="addDropdownLink">
                    <li><a class="dropdown-item" href="/kelola-pengguna">Kelola Pengguna</a></li>
                    <li><a class="dropdown-item" href="/kelola-jenis-pelatihan">Kelola Jenis Pelatihan</a></li>
                    <li><a class="dropdown-item" href="/kelola-bidang-pelatihan">Kelola Bidang Pelatihan</a></li>
                    <li><a class="dropdown-item" href="/kelola-model-pelatihan">Kelola Model Pelatihan</a></li>
                  </ul>
                </li>
                @endcan
              </ul>
            </div>
            
            {{-- <div class="d-flex ">
              <ul class="navbar-nav ">
                <li class="nav-item dropdown hidden-on-mobile mr-3">
                  <a class="nav-link dropdown-toggle" href="#" id="addDropdownLink" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="material-icons">apps</i> Kelola 
                  </a>
                  <ul class="dropdown-menu ml-3" aria-labelledby="addDropdownLink">
                    <li><a class="dropdown-item" href="/kelola-jenis-pelatihan">Jenis Pelatihan</a></li>
                    <li><a class="dropdown-item" href="/kelola-bidang-pelatihan">Bidang Pelatihan</a></li>
                    <li><a class="dropdown-item" href="/kelola-model-pelatihan">Model Pelatihan</a></li>
                  </ul>
                </li> --}}
               {{-- <li class="nav-item">
                  <a class="nav-link toggle-search" href="/search"><i class="material-icons">search</i></a>
                </li>
                <li class="nav-item hidden-on-mobile">
                  <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#"
                    data-bs-toggle="dropdown">4</a>
                  <div class="dropdown-menu dropdown-menu-end notifications-dropdown"
                    aria-labelledby="notificationsDropDown">
                    <h6 class="dropdown-header">Notifications</h6>
                    <div class="notifications-dropdown-list">
                      <a href="#">
                        <div class="notifications-dropdown-item">
                          <div class="notifications-dropdown-item-image">
                            <span class="notifications-badge bg-info text-white">
                              <i class="material-icons-outlined">campaign</i>
                            </span>
                          </div>
                          <div class="notifications-dropdown-item-text">
                            <p class="bold-notifications-text">Donec tempus nisi sed erat
                              vestibulum, eu suscipit ex laoreet</p>
                            <small>19:00</small>
                          </div>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notifications-dropdown-item">
                          <div class="notifications-dropdown-item-image">
                            <span class="notifications-badge bg-danger text-white">
                              <i class="material-icons-outlined">bolt</i>
                            </span>
                          </div>
                          <div class="notifications-dropdown-item-text">
                            <p class="bold-notifications-text">Quisque ligula dui, tincidunt nec
                              pharetra eu, fringilla quis mauris</p>
                            <small>18:00</small>
                          </div>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notifications-dropdown-item">
                          <div class="notifications-dropdown-item-image">
                            <span class="notifications-badge bg-success text-white">
                              <i class="material-icons-outlined">alternate_email</i>
                            </span>
                          </div>
                          <div class="notifications-dropdown-item-text">
                            <p>Nulla id libero mattis justo euismod congue in et metus</p>
                            <small>yesterday</small>
                          </div>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notifications-dropdown-item">
                          <div class="notifications-dropdown-item-image">
                            <span class="notifications-badge">
                              <img src="{{ asset('assets/images/avatars/avatar.png') }}" alt="">
                            </span>
                          </div>
                          <div class="notifications-dropdown-item-text">
                            <p>Praesent sodales lobortis velit ac pellentesque</p>
                            <small>yesterday</small>
                          </div>
                        </div>
                      </a>
                      <a href="#">
                        <div class="notifications-dropdown-item">
                          <div class="notifications-dropdown-item-image">
                            <span class="notifications-badge">
                              <img src="{{ asset('assets/images/avatars/avatar.png') }}" alt="">
                            </span>
                          </div>
                          <div class="notifications-dropdown-item-text">
                            <p>Praesent lacinia ante eget tristique mattis. Nam sollicitudin velit
                              sit amet auctor porta</p>
                            <small>yesterday</small>
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </li> --}}
                {{-- <li class="nav-item">
                  <a class="nav-link" href="/logout"><i class="material-icons">subdirectory_arrow_right</i></a>
                </li> --}}
              </ul>
            {{-- </div> --}}
          </div>
        </nav>
      </div>
      @if(Session::has('success'))
        <script>
            Swal.fire({
                title:'{{ Session::get('popUp_title') }}',
                text: '{{ Session::get('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
      @endif
      @if (Session::has('error'))
        <script>
          Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "{{ Session::get('error') }}",
        });
        </script>
      @endif
      @section('content')
      @show
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


    @section('script')
    {{-- <script>
      window.addEventListener('pageshow', function(event) {
          // Jika pengguna menggunakan tombol "Back" di browser
          if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
              // Redirect ke route yang menangani permintaan kembali
              window.location.href = '/handle-back-action';
          }
      });
    </script> --}}
    {{-- <script>
      // Cek apakah parameter timestamp ada dalam URL
      if (window.location.href.includes('timestamp')) {
          // Reload halaman
          window.location.reload();
      }
  </script> --}}
  
    @show
  </div>
</body>
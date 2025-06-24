@if (Auth::check())
<div class="app-sidebar">
  <div class="logo">
    {{-- <a href="/dashboard" class="logo-icon"><span class="logo-text">Monitoring Bangkom</span></a> --}}
    <div class="sidebar-user-switcher user-activity-online">
      <a href="/reset-password/{{ Auth::user()->id }}">
        <img src="{{ asset('assets/images/logo.jpg') }}" width="50">
        <span class="activity-indicator"></span>
        @php
          if(strpos(Auth::user()->nama_lengkap, ' ') !== false){
            $authusername = explode(' ', Auth::user()->nama_lengkap);
            $username = $authusername[0] . ' ' . $authusername[1];
          } else {
            $username = Auth::user()->nama_lengkap;
          }
        @endphp
        <span class="user-info-text">{{ ucwords($username) }}<br><span class="user-state-info">{{ (Auth::user()->role) }}</span></span>
      </a>
    </div>
  </div>    
  <div class="app-menu">
    {{-- <ul class="accordion-menu">
      <li class="{{ (Route::currentRouteName() == 'dashboard') ? 'active-page' : '' }}">
        <a href="{{ route('dashboard') }}"><i class="material-icons-two-tone">dashboard</i>Dashboard</a>
      </li>
    </ul> --}}
    <ul class="accordion-menu">
      <li class="sidebar-title">
        Manajemen Pelatihan
      </li>
      <li class="{{ (Route::currentRouteName() == 'sop-pelatihan') ? 'active-page' : '' }}">
        <a href="{{ route('sop-pelatihan') }}"><i class="material-icons-two-tone">storage</i>SOP Pelatihan</a>
      </li>
      <li class="{{ (Route::currentRouteName() == 'jadwal-pelatihan') ? 'active-page' : '' }}">
        <a href="{{ route('jadwal-pelatihan') }}"><i class="material-icons-two-tone">today</i>Jadwal Pelatihan</a>
      </li>
    </ul>
    <ul class="accordion-menu">
      <li class="sidebar-title">
        Menu Pelatihan
      </li>
      <li class="{{ (Route::currentRouteName() == 'pelatihan-berlangsung') ? 'active-page' : '' }}">
        <a href="{{ route('pelatihan-berlangsung') }}"><i class="material-icons-two-tone">assessment</i>Sedang Berlangsung</a>
      </li>
      {{-- <li class="{{ (Route::currentRouteName() == 'arsip-pelatihan') ? 'active-page' : '' }}">
        <a href="{{ route('arsip-pelatihan') }}"><i class="material-icons-two-tone">verified</i>Arsip Pelatihan</a>
      </li> --}}

      @can('petugas')
        <li class="{{ (Route::currentRouteName() == 'status-dokumen') ? 'active-page' : '' }}">
          <a href="{{ route('status-dokumen') }}"><i class="material-icons-two-tone">description</i>Status Dokumen</a>
        </li>
      @elsecan('supervisi')
        <li class="{{ (Route::currentRouteName() == 'tinjau-dokumen') ? 'active-page' : '' }}">
          <a href="{{ route('tinjau-dokumen') }}"><i class="material-icons-two-tone">folder_open</i>Tinjau Dokumen</a>
        </li>
      @elsecan('admin')
        {{-- <li class="{{ (Route::currentRouteName() == 'kelola-dokumen') ? 'active-page' : '' }}">
          <a href="{{ route('kelola-dokumen') }}"><i class="material-icons-two-tone">folder</i>Kelola Dokumen</a>
        </li> --}}
      @endcan
      <li class="{{ (Route::currentRouteName() == 'arsip-dokumen') ? 'active-page' : '' }}">
          <a href="{{ route('arsip-dokumen') }}"><i class="material-icons-two-tone">folder</i>Arsip Dokumen</a>
      </li>
    </ul>
    <ul class="accordion-menu">
      <li class="sidebar-title">
        Pengaturan
      </li>
      <li class="{{ (Route::currentRouteName() == 'logout') ? 'active-page' : '' }}">
        <a href="{{ route('logout') }}"><i class="material-icons">logout</i>Logout</a>
      </li>
    </ul>
  </div>
</div>
@else
  <div class="app-sidebar">
    <div class="logo">
      {{-- <a href="/dashboard" class="logo-icon"><span class="logo-text">Monitoring Bangkom</span></a> --}}
      <div class="sidebar-user-switcher user-activity-online">
        <a href="/dashboard">
          <img src="{{ asset('assets/images/logo.jpg') }}" width="50">
          <span class="activity-indicator"></span>
          <span class="user-info-text">Tamu<br><span class="user-state-info">Guest</span></span>
        </a>
      </div>
    </div>
    <div class="app-menu">
      <ul class="accordion-menu">
        <li class="{{ (Route::currentRouteName() == 'pelatihan-berlangsung') ? 'active-page' : '' }}">
          <a href="{{ route('pelatihan-berlangsung') }}"><i class="material-icons-two-tone">home</i>Home</a>
        </li>
      </ul>
      <ul class="accordion-menu">
        <li class="sidebar-title">
          Pengaturan
        </li>
        <li class="{{ (Route::currentRouteName() == 'login') ? 'active-page' : '' }}">
          <a href="{{ route('login') }}"><i class="material-icons">login</i>Login</a>
        </li>
      </ul>
    </div>
  </div>

@endif
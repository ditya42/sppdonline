<li class="heading">
    <center>Main Menu</center>
  </li>
  <li class="@yield('active-dashboard')">
    <a href="{{ route('dashboard') }}">
        <i class="icon-home"></i>
        <span>Dashboard</span>
    </a>
  </li>
  <li class="@yield('active-master')">
  <a href=".master" class="has-arrow"><i class="icon-notebook"></i><span>Master</span></a>
  <ul>

    <li class="@yield('active-jenissurat')"><a class="" href="{{ route('pegawai.jenissurat.index') }}">Jenis Surat</a></li>
    <li class="@yield('active-dasarsurat')"><a class="" href="{{ route('pegawai.dasarsurat.index') }}">Dasar Surat</a></li>
    <li class="@yield('active-suratkeluar')"><a class="" href="{{ route('pegawai.notadinas.index') }}">Surat Keluar</a></li>
  </ul>
  </li>



  <li class="@yield('active-surat')">
  <a href=".surat" class="has-arrow"><i class="fa fa-bars"></i><span>Pengajuan Surat</span></a>
  <ul>
    <li class="@yield('active-notadinas')"><a href="{{ route('pegawai.notadinas.index') }}">Nota Dinas Perjalanan</a></li>
  </ul>
  </li>



  <li>
    <a href="{{ url('/logout') }}" class="logout-trigger">
        <i class="icon-power"></i>
        <span>Logout</span>
    </a>
  </li>

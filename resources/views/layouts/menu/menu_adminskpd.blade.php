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
  {{-- <li class="@yield('active-bidang')"><a href="{{ route('bidang.index') }}">Bidang</a></li> --}}
  <li class="@yield('active-jenissurat')"><a class="" href="{{ route('adminskpd.jenissurat.index') }}">Jenis Surat</a></li>
  <li class="@yield('active-dasarsurat')"><a class="" href="{{ route('adminskpd.dasarsurat.index') }}">Dasar Surat</a></li>
  <li class="@yield('active-suratkeluar')"><a class="" href="{{ route('adminskpdsuratkeluar.suratkeluar.index') }}">Surat Keluar</a></li>
  <li class="@yield('active-notadinas')"><a class="" href="{{ route('adminskpdsuratkeluar.suratkeluar.index') }}">Nota Dinas Perjalanan</a></li>
</ul>
</li>

{{-- <li class="@yield('active-pegawai')">
  <a href=".pegawai" class="has-arrow"><i class="fa fa-users"></i><span>Pegawai</span></a>
  <ul>
    <li class="@yield('active-pegawaipns')"><a href="{{ route('pegawai.index') }}">Pegawai PNS</a></li>
    <li class="@yield('active-pegawaikontrak')"><a href="{{ route('pegawaikontrak.index') }}">Pegawai Kontrak</a></li>
  </ul>
</li> --}}

<li class="@yield('active-surat')">
<a href=".master" class="has-arrow"><i class="fa fa-bars"></i><span>Pengajuan Surat</span></a>
<ul>
  <li class="@yield('active-notadinas')"><a href="{{ route('adminskpdnotadinas.notadinas.index') }}">Nota Dinas Perjalanan</a></li>
</ul>
</li>

{{-- <li class="@yield('active-manajemenuseradmin')">
<a href="{{ route('manajemenuseradmin.index') }}">
    <i class="icon-user-following"></i>
    <span>Manajemen User</span>
</a>
</li> --}}

<li>
  <a href="{{ url('/logout') }}" class="logout-trigger">
      <i class="icon-power"></i>
      <span>Logout</span>
  </a>
</li>

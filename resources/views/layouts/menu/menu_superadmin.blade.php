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
    <li class="@yield('active-transportasi')"><a class="" href="{{ route('jenistransportasi.index') }}">Jenis Transportasi</a></li>
    <li class="@yield('active-angkutan')"><a class="" href="{{ route('jenisangkutan.index') }}">Jenis Angkutan</a></li>
    <li class="@yield('active-jenissurat')"><a class="" href="{{ route('superadmin.jenissurat.index') }}">Jenis Surat</a></li>
    <li class="@yield('active-dasarsurat')"><a class="" href="{{ route('superadmin.dasarsurat.index') }}">Dasar Surat</a></li>

  </ul>
</li>

<li class="@yield('active-manajemenuser')">
  <a href="{{ route('manajemenuser.index') }}">
      <i class="icon-user-following"></i>
      <span>Manajemen User</span>
  </a>
</li>

<li>
    <a href="{{ url('/logout') }}" class="logout-trigger">
        <i class="icon-power"></i>
        <span>Logout</span>
    </a>
</li>

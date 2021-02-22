<!doctype html>
<html lang="en">

<head>
<title>E-SPPD</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="Mplify Bootstrap 4.1.1 Admin Template">
<meta name="author" content="ThemeMakker, design by: ThemeMakker.com">

<link rel="icon" href="{{ asset('assets_admin/simpeg.ico') }}" type="image/x-icon">
<!-- Ini CSS -->
@include('layouts.css')
<!-- Ini CSS -->
</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{ asset('images/logo-tabalong.png') }}" width="48" height="48" alt="Mplify"></div>
        <p>Please wait...</p>
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay" style="display: none;"></div>

<div id="wrapper">
@include('layouts._navbar')
    <div id="leftsidebar" class="sidebar">
        <div class="sidebar-scroll">
            <nav id="leftsidebar-nav" class="sidebar-nav">
                <ul id="main-menu" class="metismenu">
                @if(Auth::user()->pegawai_kedudukanpns == 'Aktif' || Auth::user()->pegawai_kedudukanpns == 'Pejabat Non PNS' || Auth::user()->pegawai_kedudukanpns == 'Admin')
                    @if(session('role_name') == 'Super Admin')
                        @include('layouts.menu.menu_superadmin')
                    @endif
                    @if(session('role_name') == 'Admin SKPD')
                        @include('layouts.menu.menu_adminskpd')
                    @endif
                @else
                <li>
                    <a href="{{ url('/logout') }}" class="logout-trigger">
                        <i class="icon-power"></i>
                        <span>Logout</span>
                    </a>
                </li>
                @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
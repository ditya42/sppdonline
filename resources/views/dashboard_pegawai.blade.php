@extends('layouts/content-menu')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <i class="alert alert-danger">Hi {{ namaGelar($pegawai) }}</i>
                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ul>
                    </div>
                </div>
            </div>
            @if(Auth::user()->pegawai_kedudukanpns == 'Tidak Aktif' )
            <div class="row clearfix">
                <div class="col-12">
                    <div class="alert alert-info">
                        <h4 style="text-transform:uppercase;"><center>Mohon Maaf Anda Tidak Dapat Lagi Mengakses Aplikasi Ini Karena Status Anda Tidak Aktif</center></h4>
                    </div>
                </div>
            </div>
            @else
            <div class="row clearfix">
                <div class="col-12">
                    <div class="card top_report">
                        <center>
                        <img style="padding-top: 20px;" src="{{ asset('images/logo-tabalong.png') }}" alt="Mplify Logo" class="img-responsive logo" width="100">
                        <h2>E-SPPD</h2>
                        </center>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('active-dashboard')
  active
@endsection


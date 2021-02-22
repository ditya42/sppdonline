@extends('layouts/content-menu')
@section('content')
<div id="main-content" class="profilepage_2 blog-page">
  <div class="container-fluid">
      <div class="block-header">
          <div class="row">
              <div class="col-lg-5 col-md-8 col-sm-12">
                <div class="alert alert-info">
                  Selalu Lakukan Cek / Update Data Anda Di SIMPEG
                </div>
              </div>
              <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                  <ul class="breadcrumb justify-content-end">
                      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                      <li class="breadcrumb-item active">User Profile</li>
                  </ul>
              </div>
          </div>
      </div>

      <div class="row clearfix">

          <div class="col-lg-4 col-md-12">
              <div class="card profile-header">
                  <div class="body">
                      <div class="profile-image"> <img src="{{ isset($pegawai->pegawai_gambar) ? asset('https://simpeg.tabalongkab.go.id/public/images/'.$pegawai->pegawai_gambar) : asset('https://simpeg.tabalongkab.go.id/public/images/no-image.png')  }}" class="rounded-circle" width="150" alt=""> </div>
                      <div>
                          <h4 class="m-b-0"><strong>{{ namaGelar($pegawai) }}</strong></h4>
                          @if(Auth::user()->pegawai_kedudukanpns == 'Aktif')
                            <span>{{ konversi_nip($pegawai->pegawai_nip) }}</span>
                          @endif
                          <hr style="color:blue;">
                          @if(Auth::user()->pegawai_kedudukanpns == 'Aktif')
                            <small>{{ $pegawai->golongan_kode }} - {{ $pegawai->golongan_nama }}</small><br>
                          @endif
                          <small>{{ $pegawai->jabatan_nama }}<br> {{ $pegawai->skpd_nama }} <br> {{ $pegawai->subunit_nama }}</small>
                      </div>
                  </div>
              </div>
          </div>

          <div class="col-lg-8 col-md-12">

              <div class="card">
                  <div class="body">
                      <ul class="nav nav-tabs-new">
                          <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#Overview">Info</a></li>
                          <li style="margin-left: 5px;" class="nav-item"><a class="nav-link" data-toggle="tab" href="#Settings">Update Data</a></li>
                      </ul>
                  </div>
              </div>

              <div class="tab-content padding-0">

                  <div class="tab-pane active" id="Overview">
                      <div class="card">
                          <div class="body">
                            <small class="text-muted">Alamat: </small>
                            <p>{{ $pegawai->pegawai_alamat }}</p>
                            <small class="text-muted">Email: </small>
                            <p>{{ $pegawai->pegawai_email }}</p>
                            <small class="text-muted">No. HP/Telepon: </small>
                            <p>{{ $pegawai->pegawai_nohp }}</p>
                            <small class="text-muted">Tanggal Lahir: </small>
                            <p>{{ tanggal_indonesia($pegawai->pegawai_tanggallahir) }}</p>
                          </div>
                      </div>
                  </div>

                  <div class="tab-pane" id="Settings">

                      <div class="card">
                        <form action="{{ route('updateprofile',$pegawai->pegawai_id) }}" id="form-input" class="form-horizontal" method="post">
                          {{ method_field('PUT') }}
                          {{ csrf_field() }}
                          <div class="body">
                              <h6>Silakan Update Email dan Password</h6>
                              <div class="row clearfix">
                                  <div class="col-lg-12 col-md-12">
                                      <div class="form-group">
                                          <input type="email" name="email" class="form-control" placeholder="Email">
                                      </div>
                                  </div>
                              </div>
                              <button type="submit" class="btn btn-primary">Simpan</button> &nbsp;&nbsp;
                          </div>
                        </form>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
@endsection


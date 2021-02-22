@extends('layouts/content-menu')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <input type="hidden" name="pegawai_id" id="pegawai_id" value="{{ $data->pegawai_id }}">
                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Detail Pegawai</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-8 col-md-12">
                    <div class="card w_profile">
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-12">
                                    <div class="profile-image float-md-right">
                                      <img src="{{ isset($data->pegawai_gambar) ? asset('https://simpeg.tabalongkab.go.id/public/images/'.$data->pegawai_gambar) : asset('https://simpeg.tabalongkab.go.id/public/images/no-image.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-12">
                                    <h6 class="m-t-0 m-b-0"><strong>{{ konversi_nip($data->pegawai_nip) }} - {{ namaGelar($data) }}</strong></h6>
                                    <span class="job_post">{{ $data->jabatan_nama }} </span>
                                    <span class="job_post">{{ $data->golongan_kode }} - {{ $data->golongan_nama }} </span>
                                    <p>{{ $data->skpd_nama }}</p>
                                    <p>{{ $data->subunit_nama }}</p>
                                    <p>{{ $data->pegawai_alamat }}</p>
                                    <div class="m-t-15">
                                        <button class="btn btn-primary">{{ $data->pegawai_kedudukanpns }}</button>
                                        <button class="btn btn-success">{{ $data->pegawai_jeniskelamin }}</button>
                                        <button class="btn btn-info">{{ $data->agama_nama }}</button>
                                        <button class="btn btn-warning">{{ $data->statusnikah_nama }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2>Data</h2>
                        </div>
                        <div class="body">
                            <ul class="right_chat list-unstyled mb-0">
                                <li class="online">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <div class="media-body">
                                               Eselon : {{ $data->eselon_nama }} - {{ $data->pegawai_tmteselon }} <br>
                                               Jenjang : {{ $data->jenjang_nama }} - {{ $data->pegawai_tahunlulus }} <br>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

              </div>
            </div>
        </div>
@endsection

@section('active-pegawai')
  active
@endsection

@section('active-pegawaipns')
  active
@endsection

@section('script')

@endsection



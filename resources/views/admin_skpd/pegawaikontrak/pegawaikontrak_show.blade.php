@extends('layouts/content-menu')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Detail Pegawai Kontrak</li>
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
                                      <img src="{{ isset($data->pegawaikontrak_gambar) ? asset('https://simpeg.tabalongkab.go.id/images-kontrak/'.$data->pegawaikontrak_gambar) : asset('https://simpeg.tabalongkab.go.id/public/images/no-image.jpg') }}">
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-12">
                                    <h6 class="m-t-0 m-b-0"><strong>{{ $data->pegawaikontrak_nik }} - {{ namaGelarKontrak($data) }}</strong></h6>
                                    <span class="job_post">{{ $data->jeniskontrakkeahlian_nama }} </span>
                                    <p>{{ $data->skpd_nama }}</p>
                                    <p>{{ $data->subunit_nama }}</p>
                                    <p>{{ $data->pegawaikontrak_alamat }}</p>
                                    <div class="m-t-15">
                                        <button class="btn btn-primary">{{ $data->pegawaikontrak_status }}</button>
                                        <button class="btn btn-success">{{ $data->pegawaikontrak_jk }}</button>
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
                                               Jenjang : {{ $data->jenjang_nama }} - {{ $data->pegawaikontrak_tahunlulus }} <br>
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

@section('active-pegawaikontrak')
  active
@endsection

@section('script')

@endsection



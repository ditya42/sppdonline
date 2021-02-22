@extends('layouts/content-menu')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">
                        <b>Edit User</b>
                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Manajemen User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="body">
                                <form action="{{ route('manajemenuseradmin.update', $data->pr_id) }}" id="form-input" class="form-horizontal" method="post" enctype="multipart/form-data">
                                {{ csrf_field() }}{{ method_field('PUT') }}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="control-label">Pilih Pegawai</label>
                                            <input type="text"
                                              name="pegawai_nip"
                                              id="pegawai_nip"
                                              class="form-control"
                                              value="{{ $data->pegawai_nip }} / {{ namaGelar($data) }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label for="" class="control-label">Pilih Role</label>
                                            <select class="form-control select2-all" name="role_id" id="role_id">
                                                @foreach ($roles as $role)
                                                  <option value="{{ $role->role_id }}" {{ $data->role_id == $role->role_id ? 'selected' : '' }}>
                                                      {{ $role->role_name}}
                                                  </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                      <div class="form-group">
                                          <label for="" class="control-label">Pilih Bidang</label>
                                          <select class="form-control select2-all" name="bidang_id" id="bidang_id">
                                              @foreach ($bidang as $list)
                                                  <option value="{{ $list->bidang_id }}" {{ $data->bidang_id == $list->bidang_id ? 'selected' : '' }}>
                                                    {{ $list->bidang_nama}}
                                                  </option>
                                              @endforeach
                                          </select>
                                      </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                                </form>
                            </div>
                        </div>
                    </div>
            </div>


        </div>
    </div>
@endsection

@section('active-manajemenuseradmin')
  active
@endsection

@section('script')

@endsection



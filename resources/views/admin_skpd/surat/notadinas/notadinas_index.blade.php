@extends('layouts/content-menu')
@section('content')
    <div id="main-content">
        <div class="container-fluid">
            <div class="block-header">
                <div class="row">
                    <div class="col-lg-5 col-md-8 col-sm-12">

                    </div>
                    <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                        <ul class="breadcrumb justify-content-end">
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Master Surat</li>
                            <li class="breadcrumb-item">Nota Permintaan Perjalanan Dinas</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a style="margin-left: 20px;"  data-toggle="modal" onclick="addform()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                    <form method="post" id="form-verifikasi">
                                        {{ csrf_field() }}
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Kepada</th>
                                                    <th>Gol</th>
                                                    <th>Tujuan</th>
                                                    <th>Maksud</th>
                                                    <th>Tanggal</th>
                                                    <th>Lama</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </form>
                                    </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Modal Dialogs ========= -->
            @include('admin_skpd.surat.notadinas.modal.modal_notadinas')
        </div>
    </div>
@endsection

@section('active-surat')
  active
@endsection

@section('active-notadinas')
  active
@endsection

@section('script')
  <script>
    var save_method;

    function addform() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modalnotadinas').modal('show');
        $('#modalnotadinas form')[0].reset();
        $('.title').text('Tambah Nota Dinas');
        $('#simpan').show();
        $('#loading').hide();
    }

  </script>
@endsection



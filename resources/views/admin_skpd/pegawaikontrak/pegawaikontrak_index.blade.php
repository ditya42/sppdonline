@extends('layouts/content-menu')
@section('content')
<style>
  .text-wrap{
      white-space:normal;
  }
  .width-5{
      width:5px;
  }
  .width-50{
      width:50px;
  }
  .width-80{
      width:80px;
  }
  .width-180{
      width:180px;
  }
</style>

<div id="main-content">
  <div class="container-fluid">
      <div class="block-header">
          <div class="row">
              <div class="col-lg-5 col-md-8 col-sm-12">

              </div>
              <div class="col-lg-7 col-md-4 col-sm-12 text-right">
                  <ul class="breadcrumb justify-content-end">
                      <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                      <li class="breadcrumb-item active">Pegawai</li>
                  </ul>
              </div>
          </div>
      </div>
      <div class="row clearfix">
          <div class="col-12">
                  <div class="card">
                      <br>
                      <h4 class="text-center">Data Pegawai Kontrak</h4>
                      <div class="table-responsive">
                          <div class="body">
                                  <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%" id="data-tables">
                                      <thead>
                                          <tr class="text-center">
                                              <th>NIK</th>
                                              <th>Nama</th>
                                              <th>SKPD</th>
                                              <th>Aksi</th>
                                          </tr>
                                      </thead>
                                  </table>
                              </div>
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
<script>

  $(function() {
      $('#data-tables').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('pegawaikontrak.data') !!}',
        columns : [
          { data: 'pegawaikontrak_nik' },
          { data: 'pegawaikontrak_nama' },
          { data: 'skpd.skpd_nama', orderable: false },
          { data: 'action', action: 'actions', orderable: false, searchable: false }
        ],
        columnDefs: [
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-180'>" + data + "</div>";
                    },
                    targets: 1
                },
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-180'>" + data + "</div>";
                    },
                    targets: 2
                }
        ]
      });


  });

</script>
@endsection



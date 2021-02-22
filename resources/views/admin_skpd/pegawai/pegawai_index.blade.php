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
                      <h4 class="text-center">Data Pegawai SKPD</h4>
                      <div class="table-responsive">
                          <div class="body">
                                  <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%" id="data-tables">
                                      <thead>
                                          <tr class="text-center">
                                              <th>NIP</th>
                                              <th>Nama</th>
                                              <th>SKPD</th>
                                              <th>Aksi</th>
                                          </tr>
                                      </thead>
                                  </table>
                              </div>
                      </div>

                      <br>
                      <h4 class="text-center">Data Pegawai Unit Kerja</h4>
                      <div class="table-responsive">
                          <div class="body">
                                  <table class="table table-bordered table-hover dataTable table-custom" id="data-tables-uker">
                                      <thead>
                                          <tr class="text-center">
                                              <th>NIP</th>
                                              <th>Nama</th>
                                              <th>SKPD</th>
                                              <th width="100">Unit Kerja</th>
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

@section('active-pegawaipns')
  active
@endsection

@section('script')
<script>

  $(function() {
      $('#data-tables').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('pegawai.data') !!}',
        columns : [
          { data: 'pegawai_nip' },
          { data: 'pegawai_nama' },
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

      $('#data-tables-uker').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! route('pegawai.datasubunit') !!}',
        columns : [
          { data: 'pegawai_nip' },
          { data: 'pegawai_nama' },
          { data: 'skpd.skpd_nama', orderable: false },
          { data: 'subunit.subunit_nama', orderable: false },
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
                },
                {
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap width-180'>" + data + "</div>";
                    },
                    targets: 3
                }
        ]
      });

  });

</script>
@endsection



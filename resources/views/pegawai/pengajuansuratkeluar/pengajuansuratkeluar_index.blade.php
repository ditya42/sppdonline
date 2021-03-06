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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Master</li>
                            <li class="breadcrumb-item">Data Surat Keluar </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a style="margin-left: 10px;"  data-toggle="modal" onclick="addform()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Surat Keluar</button></a>

                            <div class="table-responsive">
                                <div class="body">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Tujuan Surat Keluar</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Jenis Surat</th>
                                                    <th>Nomor</th>
                                                    <th>Format Nomor</th>
                                                    <th>Perihal</th>

                                                    <th>Aksi</th>


                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                            </div>
                        </div>
                </div>
            </div>


            <!-- Modal Dialogs ========= -->
            @include('pegawai.pengajuansuratkeluar.modal.modal_suratkeluar')
            @include('pegawai.pengajuansuratkeluar.modal.modal_suratkeluar_edit')
            @include('pegawai.pengajuansuratkeluar.modal.modal_suratkeluarshow')


        </div>
    </div>
@endsection

@section('active-surat')
  active
@endsection

@section('active-suratkeluarpengajuan')
  active
@endsection

@section('script')
    <script src="{{ url('vendor/jsvalidation/js/jsvalidation.min.js' , false) }}" charset="utf-8"></script>
    {!! $JsValidator->selector('#form-input') !!}


    <script>


        var save_method;

        function addform() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modalsuratkeluar').modal('show');

            $('#modalsuratkeluar form')[0].reset();
            $('.title').text('Tambah Surat Keluar');
            $('.kepada').text('Tujuan Surat');
            $('#simpan').show();
            $('#loading').hide();
        }

        $.fn.dataTable.render.moment = function ( from, to, locale ) {
      // Argument shifting
      if ( arguments.length === 1 ) {
          locale = 'en';
          to = from;
          from = 'YYYY-MM-DD';
      }
      else if ( arguments.length === 2 ) {
          locale = 'en';
      }

      return function ( d, type, row ) {
          if (! d) {
              return type === 'sort' || type === 'type' ? 0 : d;
          }

          var m = window.moment( d, from, locale, true );

          // Order and type get a number value from Moment, everything else
          // sees the rendered value
          return m.format( type === 'sort' || type === 'type' ? 'x' : to );
      };
    };

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('pengajuansuratkeluar.data') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'kepada' },
                  { data: 'tanggal', render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' ) },
                  { data: 'kode_surat' },
                  { data: 'nomor' },
                  { data: 'format_nomor' },
                  { data: 'perihal' },

                  { data: 'action', actions: 'actions', orderable: false, searchable: false }
              ]
          });
        });

        $(function() {
          $('#modalsuratkeluar form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('pengajuansuratkeluar.store') }}";
                  else url = "pengajuansuratkeluar/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modalsuratkeluar form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modalsuratkeluar').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modalsuratkeluar').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modalsuratkeluar').modal('hide');

                  }
                  });
                  return false;
              }
          });
        });


        $(function() {
          $('#modalsuratkeluaredit form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan_edit').hide();
                  $('#loading_edit').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('pengajuansuratkeluar.store') }}";
                  else url = "pengajuansuratkeluar/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modalsuratkeluaredit form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modalsuratkeluaredit').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modalsuratkeluaredit').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modalsuratkeluaredit').modal('hide');

                  }
                  });
                  return false;
              }
          });
        });



          function editForm(id){
            save_method = "edit";
            $('#simpan_edit').show();
            $('#loading_edit').hide();
            $('input[name=_method]').val('PATCH');
            $('#modalsuratkeluaredit form')[0].reset();
            $.ajax({
              url : "pengajuansuratkeluar/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modalsuratkeluaredit').modal('show');
                $('.kepada').text('Tujuan Surat');
                $('.title').text('Edit Surat Keluar');

                $('#id').val(data.draftsuratkeluar_id);
                $('#suratkeluaredit_kepada').val(data.kepada);
                $('#suratkeluaredit_tanggal').val(data.tanggal);
                $('#suratkeluaredit_tanggal').val(data.tanggal);
                $('#suratkeluaredit_jenissurat').val(data.jenis_surat);
                $('#suratkeluaredit_format').val(data.format_nomor);
                $('#suratkeluaredit_hal').val(data.perihal);


              },
              error : function(){
                toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
              }
            });
          }



          function showForm(id){
            save_method = "edit";

            $('#loading_show').hide();
            $('input[name=_method]').val('PATCH');
            $('#modalsuratkeluarshow form')[0].reset();
            $.ajax({
              url : "pengajuansuratkeluar/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modalsuratkeluarshow').modal('show');
                $('.kepada_show').text('Tujuan Surat');
                $('.title').text('Detail Surat Keluar');

                $('#id_show').val(data.draftsuratkeluar_id);
                $('#suratkeluar_kepada_show').val(data.kepada);
                $('#suratkeluar_tanggal_show').val(data.tanggal);
                $('#suratkeluar_tanggal_show').val(data.tanggal);
                $('#suratkeluar_jenissurat_show').val(data.jenis_surat);
                $('#suratkeluar_format_show').val(data.format_nomor);
                $('#suratkeluar_hal_show').val(data.perihal);


              },
              error : function(){
                toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
              }
            });
          }

    function deleteData(id) {
      swal({
        title: "Apakah kamu yakin ?",
        text: "Akan menghapus data ini",
        icon: "warning",
        confirmButtonText: 'Hapus',
        showCancelButton: true,


        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete.value) {
            $.ajax({
            url : "pengajuansuratkeluar/"+id,
            type : "POST",
            data: {
                "_method" : "DELETE",
                "_token": "{{ csrf_token() }}"
            },
            success : function(data){
              swal("Data berhasil dihapus", {
                icon: "success",
              });
              table.ajax.reload();
            },
            error : function() {
              swal("Tidak dapat menghapus data");
            }
          });
        } else {
          swal("Batal di hapus");
        }
      });
    }



    function setujui(id) {
      swal({
        title: "Apakah Surat Keluar Ini Sudah Disetujui dan Di Tanda Tangani Pimpinan?",
        // text: "Sudah Disetujui dan Di?",
        icon: "warning",
        confirmButtonText: 'Ya',
        showCancelButton: true,


        dangerMode: true,
      })
      .then((terima) => {
        if (terima.value) {
            $.ajax({
            url : "pengajuansuratkeluar/setujui/"+id,
            type : "POST",
            data: {
                "_method" : "GET",
                "_token": "{{ csrf_token() }}"
            },
            success : function(data){
                if(data.code === 400) {
                    swal(data.status);
                            table.ajax.reload();

                      }

                if(data.code === 200) {
                    swal(data.status);
                            table.ajax.reload();

                      }


            //   swal("Nota Dinas Berhasil Didaftarkan", {
            //     icon: "success",
            //   });
            //   table.ajax.reload();
            },
            error : function() {
              swal("Tidak Dapat Didaftarkan");
            }
          });
        } else {
          swal("Batal di Daftarkan");
        }
      });
    }





    </script>





@endsection



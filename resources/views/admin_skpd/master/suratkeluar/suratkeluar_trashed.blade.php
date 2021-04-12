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
                            <li class="breadcrumb-item ">Master</li>
                            <li class="breadcrumb-item active"><a href="{{ route('adminskpdsuratkeluar.suratkeluar.index') }}">Data Surat Keluar </a></li>
                            <li class="breadcrumb-item">Data Sampah Surat Keluar </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a style="margin-left: 10px;" href="{{ route('adminskpdsuratkeluar.suratkeluar.index') }}"><button type="button" class="btn btn-success"><i class="fa fa-backward"></i> Kembali ke Surat Keluar</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Tujuan Surat Keluar</th>
                                                    <th>Tanggal Surat</th>
                                                    <th>Waktu Dihapus</th>

                                                    <th>Nomor Surat Keluar</th>
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
            @include('admin_skpd.master.suratkeluar.modal.modal_suratkeluar')


        </div>
    </div>
@endsection

@section('active-master')
  active
@endsection

@section('active-suratkeluar')
  active
@endsection

@section('script')
    <script src="{{ url('vendor/jsvalidation/js/jsvalidation.min.js' , false) }}" charset="utf-8"></script>


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
              ajax: '{!! route('adminskpdsuratkeluar.datatrash') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'kepada' },
                  { data: 'tanggal', render: $.fn.dataTable.render.moment( 'DD-MM-YYYY' ) },
                  { data: 'deleted_at' },
                //   { data: 'nomor' },
                  { data: 'nomor_lengkap' },
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
                  if(save_method == "add") url = "{{ route('adminskpdsuratkeluar.suratkeluar.store') }}";
                  else url = "suratkeluar/"+id;

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

          function editForm(id){
            save_method = "edit";
            $('#simpan').show();
            $('#loading').hide();
            $('input[name=_method]').val('PATCH');
            $('#modalsuratkeluar form')[0].reset();
            $.ajax({
              url : "suratkeluar/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modalsuratkeluar').modal('show');

                $('.title').text('Edit Surat Keluar');

                $('#id').val(data.id);
                $('#suratkeluar_kepada').val(data.kepada);
                $('#suratkeluar_tanggal').val(data.tanggal);
                $('#suratkeluar_tanggal').val(data.tanggal);
                $('#suratkeluar_jenissurat').val(data.jenis_surat);
                $('#suratkeluar_format').val(data.format_nomor);
                $('#suratkeluar_hal').val(data.perihal);

              },
              error : function(){
                toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
              }
            });
          }

    function restore(id) {
      swal({
        title: "Apakah kamu yakin ?",
        text: "Akan mengembalikan data ini",
        icon: "warning",
        confirmButtonText: 'Ya',
        showCancelButton: true,


        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete.value) {
            $.ajax({
            url : "restore/"+id,
            type : "POST",
            data: {
                "_method" : "POST",
                "_token": "{{ csrf_token() }}"
            },
            success : function(data){
              swal("Data berhasil dikembalikan", {
                icon: "success",
              });
              table.ajax.reload();
            },
            error : function() {
              swal("Tidak dapat mengembalikan data");
            }
          });
        } else {
          swal("Batal di hapus");
        }
      });
    }



    function deleteData(id) {
      swal({
        title: "Apakah kamu yakin ?",
        text: "Jika Ada Data Nota Dinas dari Surat Keluar ini juga akan dihapus",
        icon: "warning",
        confirmButtonText: 'Hapus',
        showCancelButton: true,


        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete.value) {
            $.ajax({
            url : "deletepermanen/"+id,
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



    </script>





@endsection



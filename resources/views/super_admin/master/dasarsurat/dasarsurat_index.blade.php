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

    .datatable-wide{
        margin-right: 0px;

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
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Master</li>
                            <li class="breadcrumb-item">Data Dasar Surat</li>
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
                                    <div class="datatable-wide">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Peraturan</th>
                                                    <th style="margin-right: 0px">Tentang</th>
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
            <!-- Modal Dialogs ========= -->
            @include('super_admin.master.dasarsurat.modal.modal_dasarsurat')


        </div>
    </div>
@endsection

@section('active-master')
  active
@endsection

@section('active-dasarsurat')
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
            $('#modaldasarsurat').modal('show');

            $('#modaldasarsurat form')[0].reset();
            $('.title').text('Tambah Dasar Surat');
            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('superadmindasarsurat.data') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'peraturan' },
                  { data: 'tentang' },
                  { data: 'skpd_nama' },
                  { data: 'action', actions: 'actions', orderable: false, searchable: false }
              ],
              columnDefs: [
                        {
                            render: function (data, type, full, meta) {
                                return "<div class='text-wrap'>" + data + "</div>";
                            },
                            targets: 2
                        },
                        {
                            render: function (data, type, full, meta) {
                                return "<div class='text-wrap width-100'>" + data + "</div>";
                            },
                            targets: 1
                        },
                        {
                            render: function (data, type, full, meta) {
                                return "<div class='text-wrap width-100'>" + data + "</div>";
                            },
                            targets: 3
                        }
                ]
          });
        });

        $(function() {
          $('#modaldasarsurat form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('superadmin.dasarsurat.store') }}";
                  else url = "dasarsurat/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modaldasarsurat form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modaldasarsurat').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modaldasarsurat').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modaldasarsurat').modal('hide');

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
            $('#modaldasarsurat form')[0].reset();
            $.ajax({
              url : "dasarsurat/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modaldasarsurat').modal('show');

                $('.title').text('Edit Dasar Surat');

                $('#id').val(data.id);
                $('#peraturan').val(data.peraturan);
                $('#tentang').val(data.tentang);
                $('#skpd').val(data.skpd);

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
            url : "dasarsurat/"+id,
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



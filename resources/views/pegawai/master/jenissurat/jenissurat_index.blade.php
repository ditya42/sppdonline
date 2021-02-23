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
                            <li class="breadcrumb-item active">Master</li>
                            <li class="breadcrumb-item">Data Jenis Surat</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>

                            <div class="table-responsive">
                                <div class="body">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Jenis Surat</th>
                                                    <th>Kode Surat</th>

                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                            </div>
                        </div>
                </div>
            </div>
            <!-- Modal Dialogs ========= -->
            @include('super_admin.master.jenissurat.modal.modal_jenissurat')


        </div>
    </div>
@endsection

@section('active-master')
  active
@endsection

@section('active-jenissurat')
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
            $('#modaljenissurat').modal('show');

            $('#modaljenissurat form')[0].reset();
            $('.title').text('Tambah Jenis Surat');
            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('pegawaijenissurat.data') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'jenissurat_nama' },
                  { data: 'kode_surat' },

              ]
          });
        });

        $(function() {
          $('#modaljenissurat form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('adminskpd.jenissurat.store') }}";
                  else url = "jenissurat/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modaljenissurat form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modaljenissurat').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modaljenissurat').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modaljenissurat').modal('hide');

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
            $('#modaljenissurat form')[0].reset();
            $.ajax({
              url : "jenissurat/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modaljenissurat').modal('show');

                $('.title').text('Edit Jenis Surat');

                $('#id').val(data.jenissurat_id);
                $('#jenissurat_nama').val(data.jenissurat_nama);
                $('#kode_surat').val(data.kode_surat);

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
            url : "jenissurat/"+id,
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



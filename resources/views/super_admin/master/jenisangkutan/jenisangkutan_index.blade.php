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
                            <li class="breadcrumb-item">Data Angkutan</li>
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
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Jenis Angkutan</th>
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
            @include('super_admin.master.jenisangkutan.modal.modal_jenisangkutan')

        </div>
    </div>
@endsection

@section('active-master')
  active
@endsection

@section('active-angkutan')
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
            $('#modaljenisangkutan').modal('show');
            $('#modaljenisangkutan form')[0].reset();
            $('.title').text('Tambah Jenis Angkutan');
            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('jenisangkutan.data') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'angkutan_nama' },
                  { data: 'action', actions: 'actions', orderable: false, searchable: false }
              ]
          });
        });

        $(function() {
          $('#modaljenisangkutan form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('jenisangkutan.store') }}";
                  else url = "jenisangkutan/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modaljenisangkutan form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modaljenisangkutan').modal('hide');
                      }

                      if(data.code === 200) {
                          $('#modaljenisangkutan').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })
                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modaljenisangkutan').modal('hide');
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
            $('#modaljenisangkutan form')[0].reset();
            $.ajax({
              url : "jenisangkutan/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modaljenisangkutan').modal('show');
                $('.title').text('Edit Jenis Transportasi');

                $('#id').val(data.angkutan_id);
                $('#angkutan_nama').val(data.angkutan_nama);

              },
              error : function(){
                toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
              }
            });
          }
    </script>
@endsection



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
                            <li class="breadcrumb-item">Bidang</li>
                            <li class="breadcrumb-item">Trash</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a style="margin-left: 20px;" href="{{ route('bidang.index') }}"><button type="button" class="btn btn-primary"><i class="fa fa-backward"></i> Kembali</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                    <form method="post" id="form-verifikasi">
                                        {{ csrf_field() }}
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Bidang</th>
                                                    <th>Anggaran</th>
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
        </div>
    </div>
@endsection

@section('active-master')
  active
@endsection

@section('active-bidang')
  active
@endsection

@section('script')
    <script>
        var save_method;

        function addform() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modalbidang').modal('show');
            $('#modalbidang form')[0].reset();
            $('.title').text('Tambah Bidang');
            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('bidang.datatrash') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'bidang_nama' },
                  { data: 'bidang_anggaran' },
                  { data: 'action', actions: 'actions', orderable: false, searchable: false }
              ]
          });
        });

        $(function() {
          $('#modalbidang form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('bidang.store') }}";
                  else url = "bidang/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modalbidang form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modalbidang').modal('hide');
                      }

                      if(data.code === 200) {
                          $('#modalbidang').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })
                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modalbidang').modal('hide');
                  }
                  });
                  return false;
              }
          });
        });


        function hapuspermanent(id) {
        swal({
            title: "Apakah Yakin Ingin Menghapus Data Ini Secara Permanent ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
            // closeOnConfirm: false
        }).then((result) => {
            if (result.value) {
                    $.ajax({
                        url : "{{ url('bidang/hapuspermanent/') }}/" + id,
                        type : "POST",
                        data : $('#form-verifikasi').serialize(),
                        success : function(data) {
                            toastr.success('Sukses', 'Data Berhasil Dihapus', {
                            onHidden: function () {
                                table.ajax.reload();
                            }
                            })
                        },
                        error : function() {
                            toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server')
                        }
                    });
                }
            })
        }

        function restore(id) {
        swal({
            title: "Apakah Yakin Ingin Mengaktifkan Data Ini ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Ya",
            cancelButtonText: "Batal",
        }).then((result) => {
            if (result.value) {
                    $.ajax({
                        url : "{{ url('bidang/restore/') }}/" + id,
                        type : "POST",
                        data : $('#form-verifikasi').serialize(),
                        success : function(data) {
                            toastr.success('Sukses', 'Data Berhasil Dikembalikan', {
                            onHidden: function () {
                                table.ajax.reload();
                            }
                            })
                        },
                        error : function() {
                            toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server')
                        }
                    });
                }
            })
        }
    </script>
@endsection



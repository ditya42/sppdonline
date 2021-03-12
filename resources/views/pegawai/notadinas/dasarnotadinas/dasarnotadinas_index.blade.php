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
    .width-100{
        width:100px;
    }
    .width-180{
        width:180px;
    }
    .width-250{
        width:70%;

        /* text-align: justify;
        padding-left: 0;
        padding-right: 0;
        margin: 0;
        padding: 0; */

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
                            <li class="breadcrumb-item"><a href="{{ route('pegawai.notadinas.index') }}">Nota Dinas Perjalanan</a></li>
                            <li class="breadcrumb-item active">Dasar Surat</li>
                        </ul>
                    </div>
                </div>
            </div>
            <input type="hidden" id="idnotadinas" type="text" value="{{ $notadinas->id }}" field="hidden">
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a style="margin-left: 20px;"  data-toggle="modal" onclick="addformpilih()"><button type="button" class="btn btn-primary"><i class="fa fa-hand-pointer-o"></i> Pilih Dasar Surat</button></a>
                            <a style="margin-left: 10px;"  data-toggle="modal" onclick="addformbaru()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Dasar Surat Baru</button></a>
                            <a style="margin-left: 10px;" href="{{ route('pegawai.notadinas.index') }}"><button type="button" class="btn btn-success"><i class="fa fa-backward"></i> Kembali</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                    <div class="datatable-wide">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Dasar Nota Dinas</th>
                                                    <th>Tentang</th>
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

            @include('pegawai.notadinas.dasarnotadinas.modal.modal_dasarnotapilih')
            @include('pegawai.notadinas.dasarnotadinas.modal.modal_dasarnotabaru')


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
    <script src="{{ url('vendor/jsvalidation/js/jsvalidation.min.js' , false) }}" charset="utf-8"></script>
    {!! $JsValidator->selector('#form-input') !!}




    <script>
        var save_method;

        function addformpilih() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modaldasarnotapilih form')[0].reset();
            $('#modaldasarnotabaru').modal('hide');
            $('#modaldasarnotapilih').modal('show');
            $('.title').text('Pilih Dasar Surat');

            $('#dasarnotapilih_simpan').show();
            $('#dasarnotapilih_loading').hide();
        }

        function addformbaru() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modaldasarnotabaru form')[0].reset();
            $('#modaldasarnotapilih').modal('hide');
            $('#modaldasarnotabaru').modal('show');
            $('.title').text('Tambah Dasar Surat Baru');

            $('#dasarnotabaru_simpan').show();
            $('#dasarnotabaru_loading').hide();
        }


        $(function() {
          idnota = jQuery('#idnotadinas').val();
          table = $('.table').DataTable({

              processing: true,
              serverSide: true,
              "ajax": {
                    "url": "{!! route('dasarnotadinas.data') !!}",
                    "data": {
                    "id": idnota
                    },
              },


              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'peraturan' },
                  { data: 'tentang' },
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
                                return "<div class='text-wrap'>" + data + "</div>";
                            },
                            targets: 1
                        }

                ]

          });
        });

        $(function() {
          $('#modaldasarnotapilih form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#dasarnotapilih_simpan').hide();
                  $('#dasarnotapilih_loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('dasarnotadinas.store') }}";
                  else url = "dasarnota/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modaldasarnotapilih form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modaldasarnotapilih').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modaldasarnotapilih').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modaldasarnotapilih').modal('hide');

                  }
                  });
                  return false;
              }
          });
        });



    function deleteData(id) {
      swal({
        title: "Apakah kamu yakin ?",
        confirmButtonText: "Akan menghapus data ini",
        icon: "warning",
        confirmButtonText: 'Hapus',
        showCancelButton: true,



      })
      .then((willDelete) => {
        if (willDelete.value) {
            $.ajax({
            // url: "{{ route('pegawaiberangkat.destroy',"id") }}",

            url : id,
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

    $(function() {
    $('.select-pegawai').select2({
        allowClear: false,
        placeholder: 'Masukkan NIP Pegawai',
        minimumInputLength : 4,
        ajax: {
          url: '{{ url('user/notadinas/apipegawai/') }}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.pegawai_nip+ ' / ' + item.pegawai_nama+ ' / ' + item.jabatan_nama,
                        id: item.pegawai_id,
                    }
                })
            };
          },
          cache: true
        },
        templateSelection: function (selection) {
              var result = selection.text.split('/');
            return result[0];
        }
    });

});

$(function() {
    $('.select-jabatan').select2({
        allowClear: false,
        placeholder: 'Masukkan Jabatan PNS',
        minimumInputLength : 4,
        ajax: {
          url: '{{ url('user/notadinas/apijabatan/') }}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.jabatan_nama,
                        id: item.jabatan_id,
                    }
                })
            };
          },
          cache: true
        },
        templateSelection: function (selection) {
              var result = selection.text.split('/');
            return result[0];
        }
    });

});


$(function() {
    $('.select-dasar').select2({
        allowClear: false,
        placeholder: 'Masukkan Nama Peraturan',
        minimumInputLength : 4,
        ajax: {
          url: '{{ url('user/notadinas/apidasar/') }}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.peraturan,
                        id: item.id,
                    }
                })
            };
          },
          cache: true
        },
        templateSelection: function (selection) {
              var result = selection.text.split('/');
            return result[0];
        }
    });

});



    </script>





@endsection



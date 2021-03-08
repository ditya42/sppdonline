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
                            <li class="breadcrumb-item active">Pegawai Berangkat</li>
                        </ul>
                    </div>
                </div>
            </div>
            <input type="hidden" id="idnotadinas" type="text" value="{{ $notadinas->id }}" field="hidden">
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a style="margin-left: 20px;"  data-toggle="modal" onclick="addform()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button></a>
                            <a style="margin-left: 10px;" href="{{ route('pegawai.notadinas.index') }}"><button type="button" class="btn btn-success"><i class="fa fa-backward"></i> Kembali</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                    <div class="datatable-wide">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th width="5">No.</th>
                                                    <th>Nama Pegawai Yang Berangkat</th>
                                                    <th>Jabatan Pegawai</th>
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
            @include('pegawai.notadinas.pegawaiberangkat.modal.modal_pegawaiberangkat')


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

        function addform() {
            save_method = "add";
            $('input[name=_method]').val('POST');
            $('#modalpegawaiberangkat form')[0].reset();
            $('#modalpegawaiberangkat').modal('show');
            $('.title').text('Pegawai Berangkat');

            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          idnota = jQuery('#idnotadinas').val();
          table = $('.table').DataTable({

              processing: true,
              serverSide: true,
              "ajax": {
                    "url": "{!! route('pegawaiberangkat.data') !!}",
                    "data": {
                    "id": idnota
                    },
              },


              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'nama_gelar' },
                  { data: 'jabatan_nama' },
                  { data: 'action', actions: 'actions', orderable: false, searchable: false }
              ],

          });
        });

        $(function() {
          $('#modalpegawaiberangkat form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('pegawaiberangkat.store') }}";
                  else url = "pegawaiberangkat/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modalpegawaiberangkat form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modalpegawaiberangkat').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modalpegawaiberangkat').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modalpegawaiberangkat').modal('hide');

                  }
                  });
                  return false;
              }
          });
        });

        //   function editForm(id){
        //     save_method = "edit";
        //     $('#simpan').show();
        //     $('#loading').hide();
        //     $('input[name=_method]').val('PATCH');
        //     $('#modalnotadinas form')[0].reset();
        //     $.ajax({
        //       url : "notadinas/"+id+"/edit",
        //       type : "GET",
        //       dataType : "JSON",
        //       success : function(data){
        //         $('#modalnotadinas').modal('show');

        //         $('.title').text('Edit Pengajuan Nota Dinas');

        //         $('#label_kepada').text('Tujuan Surat : '+data.jabatan_kepada);
        //         $('.kepada').text('Ganti Tujuan Surat');

        //         $('#label_dari').text('Pengirim Surat: '+data.jabatan_dari);
        //         $('.dari').text('Ganti Pengirim Surat');

        //         $('#label_disposisi1').text('Pejabat Pemberi Disposisi: '+data.jabatan_disposisi1);
        //         $('.disposisi1').text('Ganti Pejabat Pemberi Disposisi');

        //         $('#label_disposisi2').text('Pejabat Pemberi Disposisi: '+data.jabatan_disposisi2);
        //         $('.disposisi2').text('Ganti Pejabat Pemberi Disposisi');


        //         $('#id').val(data.id);
        //         $('#notadinas_kepada').val(data.jabatan_kepada).trigger('change');
        //         $('#notadinas_dari').val(data.jabatan_dari).trigger('change');
        //         $('#notadinas_disposisi1').val(data.jabatan_disposisi1).trigger('change');
        //         $('#notadinas_disposisi2').val(data.jabatan_disposisi2).trigger('change');

        //         $('#notadinas_tanggal').val(data.tanggal_surat);
        //         $('#notadinas_jenissurat').val(data.jenis_surat);
        //         $('#notadinas_format').val(data.format_nomor);
        //         $('#notadinas_lampiran').val(data.lampiran);
        //         $('#notadinas_hal').val(data.hal);
        //         $('#notadinas_isi').val(data.isi);
        //         $('#notadinas_tujuan').val(data.tujuan);
        //         $('#notadinas_tanggaldari').val(data.tanggal_dari);
        //         $('#notadinas_tanggalsampai').val(data.tanggal_sampai);
        //         $('#notadinas_anggaran').val(data.anggaran);


        //       },
        //       error : function(){
        //         toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
        //       }
        //     });
        //   }



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






    </script>





@endsection



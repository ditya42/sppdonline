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
                            <li class="breadcrumb-item"><a href="#"><i class="icon-home"></i></a></li>
                            <li class="breadcrumb-item active">Master</li>
                            <li class="breadcrumb-item">Nota Dinas Perjalanan</li>
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
                                                    <th>Tujuan Surat</th>
                                                    {{-- <th>Dari</th> --}}
                                                    <th>Jenis</th>
                                                    <th>Nomor</th>
                                                    <th>Format Nomor</th>
                                                    {{-- <th>PNS Berangkat</th>
                                                    <th>Dasar</th> --}}

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
            @include('pegawai.notadinas.modal.modal_notadinas')



        </div>
    </div>
@endsection

@section('active-master')
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
            $('#modalnotadinas').modal('show');

            $('#modalnotadinas form')[0].reset();

            $('.title').text('Pengajuan Nota Dinas');
            $('.kepada').text('Tujuan Surat');
            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('pegawainotadinas.data') !!}',
              columns: [
                  { data: 'DT_RowIndex', orderable: false, searchable: false},
                  { data: 'jabatan_nama' },
                //   { data: 'pegawai_nama' },
                  { data: 'kode_surat' },
                  { data: 'nomor' },
                  { data: 'format_nomor' },

                //   { data: 'pns_berangkat',  actions: 'actions', orderable: false, searchable: false },
                //   { data: 'dasar_surat',  actions: 'actions', orderable: false, searchable: false },
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
          $('#modalnotadinas form').validator().on('submit', function(e) {
              if(!e.isDefaultPrevented()) {
                  $('#simpan').hide();
                  $('#loading').show();
                  var id = $('#id').val();
                  if(save_method == "add") url = "{{ route('pegawai.notadinas.store') }}";
                  else url = "notadinas/"+id;

                  $.ajax({
                  url : url,
                  type : "POST",
                  data : $('#modalnotadinas form').serialize(),
                  success : function(data){
                      if(data.code === 400) {
                          toastr.error('Error', data.status);
                          $('#modalnotadinas').modal('hide');

                      }

                      if(data.code === 200) {
                          $('#modalnotadinas').modal('hide');
                              toastr.success('Sukses', data.status, {
                              onHidden: function () {
                                  table.ajax.reload();
                              }
                          })

                      }
                  },
                  error : function(){
                      toastr.error('Gagal', 'Mohon Maaf Terjadi Kesalahan Pada Server');
                      $('#modalnotadinas').modal('hide');

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
            $('#modalnotadinas form')[0].reset();
            $.ajax({
              url : "notadinas/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modalnotadinas').modal('show');

                $('.title').text('Edit Pengajuan Nota Dinas');

                $('.kepada').text('Ganti Tujuan Surat');

                $('#id').val(data.id);
                $('#notadinas_kepada').val(data.kepada).trigger('change');
                $('#notadinas_tanggal').val(data.tanggal_surat);
                $('#notadinas_jenissurat').val(data.jenis_surat);
                $('#notadinas_format').val(data.format_nomor);
                $('#notadinas_lampiran').val(data.lampiran);
                $('#notadinas_hal').val(data.Hal);
                $('#notadinas_isi').val(data.isi);
                $('#notadinas_tujuan').val(data.tujuan);
                $('#notadinas_tanggaldari').val(data.tanggal_dari);
                $('#notadinas_tanggalsampai').val(data.tanggal_sampai);
                $('#notadinas_anggaran').val(data.anggaran);


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

    $(function() {
    $('.select-pegawai').select2({
        allowClear: false,
        placeholder: 'Masukan NIP Pegawai',
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
        placeholder: 'Masukan Jabatan PNS',
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



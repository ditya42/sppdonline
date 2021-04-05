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

                            <li class="breadcrumb-item active">Nota Dinas Perjalanan</li>
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
                                                    <th>Tujuan Nota Dinas</th>
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
            @include('super_admin.master.notadinas.modal.modal.modal_notadinas')
            @include('super_admin.master.notadinas.modal.modal.modal_notadinasshow')



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
            $('#modalnotadinas form')[0].reset();
            $('#modalnotadinas').modal('show');
            $('.title').text('Pengajuan Nota Dinas');
            $('.kepada').text('Tujuan Surat');
            $('.dari').text('Dari');
            $('.skpd').text('SKPD');
            $('.disposisi1').text('Pejabat Pemberi Disposisi');
            $('.disposisi2').text('Pejabat Pemberi Disposisi');
            $('#simpan').show();
            $('#loading').hide();
        }

        $(function() {
          table = $('.table').DataTable({
              processing: true,
              serverSide: true,
              ajax: '{!! route('superadminnotadinas.data') !!}',
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
                  if(save_method == "add") url = "{{ route('superadmin.notadinas.store') }}";
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

                $('#label_kepada').text('Tujuan Surat : '+data.jabatan_kepada);
                $('.kepada').text('Ganti Tujuan Surat');

                $('#label_dari').text('Pengirim Surat: '+data.jabatan_dari);
                $('.dari').text('Ganti Pengirim Surat');

                $('#label_skpd').text('SKPD: '+data.skpd_nama);
                $('.skpd').text('Ganti SKPD');

                $('#label_disposisi1').text('Pejabat Pemberi Disposisi: '+data.jabatan_disposisi1);
                $('.disposisi1').text('Ganti Pejabat Pemberi Disposisi');

                $('#label_disposisi2').text('Pejabat Pemberi Disposisi: '+data.jabatan_disposisi2);
                $('.disposisi2').text('Ganti Pejabat Pemberi Disposisi');


                $('#id').val(data.id);
                $('#notadinas_kepada').val(data.jabatan_kepada).trigger('change');
                $('#notadinas_dari').val(data.jabatan_dari).trigger('change');
                $('#notadinas_skpd').val(data.jabatan_dari).trigger('change');

                $('#notadinas_disposisi1').val(data.jabatan_disposisi1).trigger('change');
                $('#notadinas_disposisi2').val(data.jabatan_disposisi2).trigger('change');

                $('#notadinas_tanggal').val(data.tanggal_surat);
                $('#notadinas_jenissurat').val(data.jenis_surat);
                $('#notadinas_format').val(data.format_nomor);
                $('#notadinas_lampiran').val(data.lampiran);
                $('#notadinas_hal').val(data.hal);
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


          function showForm(id){
            save_method = "edit";

            $('#loadingshow').hide();
            $('input[name=_method]').val('PATCH');
            $('#modalnotadinasshow form')[0].reset();
            $.ajax({
              url : "notadinas/"+id+"/edit",
              type : "GET",
              dataType : "JSON",
              success : function(data){
                $('#modalnotadinasshow').modal('show');

                $('.title').text('Detail Pengajuan Nota Dinas');

                $('#label_kepada_show').text('Tujuan Surat : '+data.jabatan_kepada);

                $('#label_dari_show').text('Pengirim Surat: '+data.jabatan_dari);

                $('#label_skpd_show').text('SKPD: '+data.skpd_nama);

                $('#label_disposisi1_show').text('Pejabat Pemberi Disposisi: '+data.jabatan_disposisi1);


                $('#label_disposisi2_show').text('Pejabat Pemberi Disposisi: '+data.jabatan_disposisi2);



                $('#id').val(data.id);
                $('#notadinas_kepada_show').val(data.jabatan_kepada).trigger('change');
                $('#notadinas_dari_show').val(data.jabatan_dari).trigger('change');
                $('#notadinas_disposisi1_show').val(data.jabatan_disposisi1).trigger('change');
                $('#notadinas_disposisi2_show').val(data.jabatan_disposisi2).trigger('change');

                $('#notadinas_tanggal_show').val(data.tanggal_surat);
                $('#notadinas_jenissurat_show').val(data.jenis_surat);
                $('#notadinas_format_show').val(data.format_nomor);
                $('#notadinas_lampiran_show').val(data.lampiran);
                $('#notadinas_hal_show').val(data.hal);
                $('#notadinas_isi_show').val(data.isi);
                $('#notadinas_tujuan_show').val(data.tujuan);
                $('#notadinas_tanggaldari_show').val(data.tanggal_dari);
                $('#notadinas_tanggalsampai_show').val(data.tanggal_sampai);
                $('#notadinas_anggaran_show').val(data.anggaran);


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
            url : "notadinas/"+id,
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
        title: "Apakah Nota Dinas Ini Sudah Disetujui dan Di TandaTangani Pimpinan?",
        // text: "Sudah Disetujui dan Di?",
        icon: "warning",
        confirmButtonText: 'Ya',
        showCancelButton: true,


        dangerMode: true,
      })
      .then((terima) => {
        if (terima.value) {
            $.ajax({
            url : "notadinas/setujui/"+id,
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


                      if(data.code === 500) {
                    swal(data.status);
                            table.ajax.reload();

                      }

                      if(data.code === 600) {
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

    $(function() {
    $('.select-pegawai').select2({
        allowClear: false,
        placeholder: 'Masukkan NIP Pegawai',
        minimumInputLength : 4,
        ajax: {
          url: '{{ url('superadmin/notadinas/apipegawai/') }}',
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
          url: '{{ url('superadmin/notadinas/apijabatan/') }}',
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
    $('.select-skpd').select2({
        allowClear: false,
        placeholder: 'Masukkan SKPD',
        minimumInputLength : 4,
        ajax: {
          url: '{{ url('superadmin/notadinas/apiskpd/') }}',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
            return {
              results:  $.map(data, function (item) {
                    return {
                        text: item.skpd_nama,
                        id: item.skpd_id,
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



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
                            <li class="breadcrumb-item active">Manajemen User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a href="{{ route('manajemenuseradmin.create') }}" style="margin-left: 20px;"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                  <form method="post" id="form-verifikasi">
                                    {{ csrf_field() }}
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Level</th>
                                                    <th>Bidang</th>
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

@section('active-manajemenuseradmin')
  active
@endsection

@section('script')
<script>

  $(function() {
      table = $('.table').DataTable({
          "processing" : true,
          "serverside" : true,
          "ajax" : {
          "url" : "{{ route('manajemenuseradmin.data') }}",
          "type" : "GET"
          }
      });
  });

  function hapus(id) {
    swal({
        title: "Apakah Yakin Ingin Menghapus Data Ini ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url : "{{ url('manajemenuseradmin/hapus/') }}/" + id,
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

</script>
@endsection



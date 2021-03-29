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
                            <li class="breadcrumb-item active">Manajemen User</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-12">
                        <div class="card">
                            <br>
                            <a href="{{ route('manajemenuser.create') }}" style="margin-left: 20px;"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button></a>
                            <div class="table-responsive">
                                <div class="body">
                                        <table class="table table-bordered table-hover js-basic-example dataTable table-custom" width="100%">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Level</th>
                                                    <th>SKPD</th>
                                                    <th>Uker</th>
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
    </div>
@endsection

@section('active-manajemenuser')
  active
@endsection

@section('script')
<script>

  $(function() {
      table = $('.table').DataTable({
          "processing" : true,
          "serverside" : true,
          "ajax" : {
          "url" : "{{ route('manajemenuser.data') }}",
          "type" : "GET"
          }
      });
  });

  function deleteData(id){
   if(confirm("Apakah yakin data akan dihapus?")){
     $.ajax({
       url : "manajemenuser/"+id,
       type : "POST",
       data : {'_method' : 'DELETE', '_token' : $('meta[name=csrf-token]').attr('content')},
       success : function(data){
         table.ajax.reload();
       },
       error : function(){
         alert("Tidak dapat menghapus data!");
       }
     });
   }
  }

</script>
@endsection



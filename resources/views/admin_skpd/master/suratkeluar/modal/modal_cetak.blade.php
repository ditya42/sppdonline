<!-- Default Size -->
<div class="modal fade" id="modalcetak" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-cetak" class="form-horizontal" data-toggle="validator" method="post" action="{!! route('adminskpdsuratkeluar.cetak') !!}">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalcetak-label">Cetak Buku Surat Keluar</h4>
            </div>
                <div class="modal-body">

                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">


                            {{-- <label class="tahun">Cetak Buku Surat Keluar Tahun</label> --}}
                            {{-- <select name="year" id="year" class="form-control bt_select">
                                <option value="">Pilih Tahun</option>
                            </select> --}}
                            <label class="tahun">Masukkan Tahun Buku Surat Keluar</label>
                                <input type="number" name="tahun" id="tahun" class="form-control">



                        </div>


                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="cetak" class="btn btn-success">Cetak</button>
                    <button type="button" id="loadingcetak" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload();">Tutup</button> --}}
                </div>
          </div>
        </form>
    </div>
  </div>

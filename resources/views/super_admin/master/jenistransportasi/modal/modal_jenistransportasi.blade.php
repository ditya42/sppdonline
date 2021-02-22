<!-- Default Size -->
<div class="modal fade" id="modaljenistransportasi" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
      <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
      {{ csrf_field() }} {{ method_field('POST') }}
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="title" id="modaljenistransportasi-label"></h4>
          </div>
              <div class="modal-body">
                <input type="hidden" id="id" name="id">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Jenis Transportasi</label>
                        <input type="text" class="form-control" name="transportasi_nama" id="transportasi_nama">
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="submit" id="simpan" class="btn btn-success">Simpan</button>
                  <button type="button" id="loading" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                  <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
              </div>
        </div>
      </form>
  </div>
</div>
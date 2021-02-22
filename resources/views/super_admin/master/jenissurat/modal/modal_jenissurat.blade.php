<!-- Default Size -->
<div class="modal fade" id="modaljenissurat" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
      <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
      {{ csrf_field() }} {{ method_field('POST') }}
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="title" id="modaljenissurat-label"></h4>
          </div>
              <div class="modal-body">
                <input type="hidden" id="id" name="id">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Jenis Surat</label>
                        <input type="text" class="form-control" name="jenissurat_nama" id="jenissurat_nama"><br>

                        <label>Kode Surat</label>
                        <input type="text" class="form-control" name="kode_surat" id="kode_surat">
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

<!-- Default Size -->
<div class="modal fade" id="modaldasarnotapilih" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input-dasarnotapilih" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modaldasarnotapilih-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="dasarnotapilih_id" name="dasarnotapilih_notadinas" value="{{ $notadinas->id }}">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="input-group mb-1">
                          <select class="form-control select-dasar" name="dasarnotapilih_iddasar" id="dasarnotapilih_iddasar">
                          </select>
                        </div><br>

                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="dasarnotapilih_simpan" class="btn btn-success">Simpan</button>
                    <button type="button" id="dasarnotapilih_loading" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
          </div>
        </form>
    </div>
  </div>

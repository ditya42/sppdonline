<!-- Default Size -->
<div class="modal fade" id="modaldasarnotabaru" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input-dasarnotabaru" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modaldasarnotabaru-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="dasarnotabaru_id" name="dasarnotabaru_notadinas" value="{{ $notadinas->id }}">
                  <div class="col-md-12">
                      <div class="form-group">

                        <label>Peraturan/Nama Surat</label>
                        <input type="text" class="form-control" name="dasarnotabaru_peraturan" id="dasarnotabaru_peraturan"><br>

                        <label>Tentang/Perihal</label>
                        ​<textarea id="dasarnotabaru_tentang" name="dasarnotabaru_tentang" rows="10" cols="58"></textarea>

                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="dasarnotabaru_simpan" class="btn btn-success">Simpan</button>
                    <button type="button" id="dasarnotabaru_loading" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                </div>
          </div>
        </form>
    </div>
  </div>

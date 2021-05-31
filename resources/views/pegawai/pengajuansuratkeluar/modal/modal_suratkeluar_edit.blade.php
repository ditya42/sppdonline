<!-- Default Size -->
<div class="modal fade" id="modalsuratkeluaredit" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input-edit" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalsuratkeluaredit-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">

                            <label id="label_kepada"></label><br>
                            <label class="kepada"></label>
                            <input type="text" class="form-control" name="suratkeluaredit_kepada" id="suratkeluaredit_kepada">

                            <br>



                          <label for="suratkeluar_tanggal">Tanggal Surat</label>
                          <input class="form-control" type="date" id="suratkeluaredit_tanggal" name="suratkeluaredit_tanggal"><br>





                            <label for="suratkeluaredit_jenis">Jenis Surat</label>
                        <select name="suratkeluaredit_jenissurat" id="suratkeluaredit_jenissurat" class="form-control">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenissurat as $jenis)
                                <option value="{{ $jenis->jenissurat_id }}">{{ $jenis->kode_surat }}</option>
                            @endforeach
                        </select>
                        <br>

                        <label>Format Nomor Surat</label><br>
                        <input type="text" size="35" name="suratkeluaredit_format" id="suratkeluaredit_format" class="form-control">
                          <br><label>Contoh: /BKPP/DASI.KHP.1/823/01/2020 (tanpa Nomor Surat)</label><br><br>



                          <label>Hal</label>
                          ​<textarea id="suratkeluaredit_hal" name="suratkeluaredit_hal" rows="2" cols="53"></textarea><br>

                        </div>


                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="simpan_edit" class="btn btn-success">Simpan</button>
                    <button type="button" id="loading_edit" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload();">Tutup</button> --}}
                </div>
          </div>
        </form>
    </div>
  </div>

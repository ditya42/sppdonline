<!-- Default Size -->
<div class="modal fade" id="modalsuratkeluarshow" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalsuratkeluarshow-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="id_show" name="id_show">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">

                            <label id="label_kepada_show"></label><br>
                            <label class="kepada_show"></label>
                            <input type="text" class="form-control" name="suratkeluar_kepada_show" id="suratkeluar_kepada_show">

                            <br>

                          <label for="suratkeluar_tanggal_show">Tanggal Surat</label>
                          <input class="form-control" type="date" id="suratkeluar_tanggal_show" name="suratkeluar_tanggal_show"><br>


                        <label for="suratkeluar_jenis_show">Jenis Surat</label>
                        <select name="suratkeluar_jenissurat_show" id="suratkeluar_jenissurat_show" class="form-control">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenissurat as $jenis)
                                <option value="{{ $jenis->jenissurat_id }}">{{ $jenis->kode_surat }}</option>
                            @endforeach
                        </select>
                        <br>

                        <label>Format Nomor Surat</label>
                          <input type="text" class="form-control" name="suratkeluar_format_show" id="suratkeluar_format_show">
                          <label>Contoh: /BKPP/DASI.KHP.1/823/12/2021 (tanpa Nomor Surat)</label><br><br>

                          <label>Hal</label>
                          ​<textarea id="suratkeluar_hal_show" name="suratkeluar_hal_show" rows="2" cols="53"></textarea><br>

                        </div>


                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="submit" id="simpan_show" class="btn btn-success">Simpan</button> --}}
                    <button type="button" id="loading_show" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                    {{-- <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload();">Tutup</button> --}}
                </div>
          </div>
        </form>
    </div>
  </div>

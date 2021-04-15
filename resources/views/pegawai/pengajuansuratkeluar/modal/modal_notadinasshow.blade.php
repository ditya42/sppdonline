<!-- Default Size -->
<div class="modal fade" id="modalnotadinasshow" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalnotadinasshow-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">

                            <label id="label_kepada_show"></label><br><br>

                            <label id="label_dari_show"></label><br><br>

                            <label id="label_skpd_show"></label><br>





                          <label for="notadinas_tanggal_show">Tanggal Surat</label>
                          <input class="form-control" type="date" id="notadinas_tanggal_show" name="notadinas_tanggal_show"><br>



                            <label for="notadinas_tanggal_show">Jenis Surat</label>
                        <select name="notadinas_jenissurat_show" id="notadinas_jenissurat_show" class="form-control">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenissurat as $jenis)
                                <option value="{{ $jenis->jenissurat_id }}">{{ $jenis->kode_surat }}</option>
                            @endforeach
                        </select><br>

                        <label>Format Nomor Surat</label>
                          <input type="text" class="form-control" name="notadinas_format_show" id="notadinas_format_show">
                          <label>Contoh: /BKPP/DASI.KHP.1/823/12/2021 (tanpa Nomor Surat)</label><br><br>


                          <label>Lampiran</label>
                          <input type="text" class="form-control" name="notadinas_lampiran_show" id="notadinas_lampiran_show" value="-"><br>

                          <label>Hal</label>
                          ​<textarea id="notadinas_hal_show" name="notadinas_hal_show" rows="2" cols="53"></textarea><br>

                          <label>Isi Surat</label>
                          ​<textarea id="notadinas_isi_show" name="notadinas_isi_show" rows="5" cols="53"></textarea><br>

                          <label>Tujuan Perjalanan</label>
                          ​<textarea id="notadinas_tujuan_show" name="notadinas_tujuan_show" rows="2" cols="53"></textarea><br><br>

                          <label for="notadinas_tanggaldari_show">Dari Tanggal</label>
                          <input class="form-control" type="date" id="notadinas_tanggaldari_show" name="notadinas_tanggaldari_show"><br>

                          <label for="notadinas_tanggalsampai_show">Sampai Tanggal</label>
                          <input class="form-control" type="date" id="notadinas_tanggalsampai_show" name="notadinas_tanggalsampai_show"><br>

                          <label>Anggaran yang dipakai</label>
                          ​<textarea id="notadinas_anggaran_show" name="notadinas_anggaran_show" rows="2" cols="53"></textarea><br><br>

                          <label id="label_disposisi1_show"></label><br>
                         <br>

                            <label id="label_disposisi2_show"></label><br>

                        </div>


                      </div>
                  </div>
                </div>
                <div class="modal-footer">

                    <button type="button" id="loadingshow" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload();">Tutup</button>
                </div>
          </div>
        </form>
    </div>
  </div>

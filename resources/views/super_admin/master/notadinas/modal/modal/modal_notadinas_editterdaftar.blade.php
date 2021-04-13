<!-- Default Size -->
<div class="modal fade" id="modaledit2" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modaledit2-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="id_edit2" name="id_edit2">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">

                            <label id="label_kepada_edit2"></label><br>
                            <label class="kepada_edit2"></label>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_kepada_edit2" id="notadinas_kepada_edit2">
                              </select>
                            </div><br>




                            <label id="label_dari_edit2"></label><br>
                            <label class="dari_edit2"></label>

                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_dari_edit2" id="notadinas_dari_edit2">
                              </select>
                            </div><br>



                          <label for="notadinas_tanggal_edit2">Tanggal Surat</label>
                          <input class="form-control" type="date" id="notadinas_tanggal_edit2" name="notadinas_tanggal_edit2"><br>



                            <label for="notadinas_tanggal_edit2">Jenis Surat</label>
                        <select name="notadinas_jenissurat_edit2" id="notadinas_jenissurat_edit2" class="form-control">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenissurat as $jenis)
                                <option value="{{ $jenis->jenissurat_id }}">{{ $jenis->kode_surat }}</option>
                            @endforeach
                        </select><br>

                        <label>Format Nomor Surat</label>
                          <input type="text" class="form-control" name="notadinas_format_edit2" id="notadinas_format_edit2">
                          <label>Contoh: /BKPP/DASI.KHP.1/823/12/2021 (tanpa Nomor Surat)</label><br><br>


                          <label>Lampiran</label>
                          <input type="text" class="form-control" name="notadinas_lampiran_edit2" id="notadinas_lampiran_edit2" value="-"><br>

                          <label>Hal</label>
                          ​<textarea id="notadinas_hal_edit2" name="notadinas_hal_edit2" rows="2" cols="53"></textarea><br>

                          <label>Isi Surat</label>
                          ​<textarea id="notadinas_isi_edit2" name="notadinas_isi_edit2" rows="5" cols="53"></textarea><br>

                          <label>Tujuan Perjalanan</label>
                          ​<textarea id="notadinas_tujuan_edit2" name="notadinas_tujuan_edit2" rows="2" cols="53"></textarea><br><br>

                          <label for="notadinas_tanggaldari_edit2">Dari Tanggal</label>
                          <input class="form-control" type="date" id="notadinas_tanggaldari_edit2" name="notadinas_tanggaldari_edit2"><br>

                          <label for="notadinas_tanggalsampai_edit2">Sampai Tanggal</label>
                          <input class="form-control" type="date" id="notadinas_tanggalsampai_edit2" name="notadinas_tanggalsampai_edit2"><br>

                          <label>Anggaran yang dipakai</label>
                          ​<textarea id="notadinas_anggaran_edit2" name="notadinas_anggaran_edit2" rows="2" cols="53"></textarea><br><br>

                          <label id="label_disposisi1_edit2"></label><br>
                          <label class="disposisi1_edit2"></label>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_disposisi1_edit2" id="notadinas_disposisi1_edit2">
                              </select>
                            </div><br>

                            <label id="label_disposisi2_edit2"></label><br>
                            <label class="disposisi2_edit2"></label>

                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_disposisi2_edit2" id="notadinas_disposisi2_edit2">
                              </select>
                            </div><br>



                        </div>


                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="simpan_edit2" class="btn btn-success">Simpan</button>
                    <button type="button" id="loading_edit2" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload();">Tutup</button>
                </div>
          </div>
        </form>
    </div>
  </div>

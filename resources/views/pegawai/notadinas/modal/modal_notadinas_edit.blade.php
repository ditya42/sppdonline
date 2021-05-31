<!-- Default Size -->
<div class="modal fade" id="modalnotadinasedit" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input-edit" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalnotadinasedit-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">

                            <label id="label_kepada_edit"></label><br>
                            <label class="kepada_edit"></label>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinasedit_kepada" id="notadinasedit_kepada">
                              </select>
                            </div><br>


                            <label id="label_dari_edit"></label><br>
                            <label class="dari_edit"></label>

                            <div class="input-group mb-1">
                              <select class="form-control select-pegawai" name="notadinasedit_dari" id="notadinasedit_dari">
                              </select>
                            </div><br>



                          <label for="notadinasedit_tanggal">Tanggal Surat</label>
                          <input class="form-control" type="date" id="notadinasedit_tanggal" name="notadinasedit_tanggal"><br>



                            <label for="notadinas_tanggal">Jenis Surat</label>
                        <select name="notadinasedit_jenissurat" id="notadinasedit_jenissurat" class="form-control">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenissurat as $jenis)
                                <option value="{{ $jenis->jenissurat_id }}">{{ $jenis->kode_surat }}</option>
                            @endforeach
                        </select><br>

                        <label>Format Nomor Surat</label>
                          <input type="text" class="form-control" name="notadinasedit_format" id="notadinasedit_format">
                          <label>Contoh: /BKPP/DASI.KHP.1/823/12/2021 (tanpa Nomor Surat)</label><br><br>


                          <label>Lampiran</label>
                          <input type="text" class="form-control" name="notadinasedit_lampiran" id="notadinasedit_lampiran" value="-"><br>

                          <label>Hal</label>
                          ​<textarea id="notadinasedit_hal" name="notadinasedit_hal" rows="2" cols="53"></textarea><br>

                          <label>Isi Surat</label>
                          ​<textarea id="notadinasedit_isi" name="notadinasedit_isi" rows="5" cols="53"></textarea><br>

                          <label>Tujuan Perjalanan</label>
                          ​<textarea id="notadinasedit_tujuan" name="notadinasedit_tujuan" rows="2" cols="53"></textarea><br><br>

                          <label for="notadinasedit_tanggaldari">Dari Tanggal</label>
                          <input class="form-control" type="date" id="notadinasedit_tanggaldari" name="notadinasedit_tanggaldari"><br>

                          <label for="notadinasedit_tanggalsampai">Sampai Tanggal</label>
                          <input class="form-control" type="date" id="notadinasedit_tanggalsampai" name="notadinasedit_tanggalsampai"><br>

                          <label>Anggaran yang dipakai</label>
                          ​<textarea id="notadinasedit_anggaran" name="notadinasedit_anggaran" rows="2" cols="53"></textarea><br><br>

                          <label id="label_disposisi1_edit"></label><br>
                          <label class="disposisi1_edit"></label>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinasedit_disposisi1" id="notadinasedit_disposisi1">
                              </select>
                            </div><br>

                            <label id="label_disposisi2_edit"></label><br>
                            <label class="disposisi2_edit"></label>

                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinasedit_disposisi2" id="notadinasedit_disposisi2">
                              </select>
                            </div><br>

                        </div>


                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="simpan_edit" class="btn btn-success">Simpan</button>
                    <button type="button" id="loading_edit" class="btn btn-success" disabled="disabled"><i class="fa fa-refresh fa-spin"></i> <span>Loading...</span></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onClick="window.location.reload();">Tutup</button>
                </div>
          </div>
        </form>
    </div>
  </div>

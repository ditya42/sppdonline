<!-- Default Size -->
<div class="modal fade" id="modalnotadinas" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
        {{ csrf_field() }} {{ method_field('POST') }}
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalnotadinas-label"></h4>
            </div>
                <div class="modal-body">
                  <input type="hidden" id="id" name="id">
                  <div class="col-md-12">
                      <div class="form-group">

                        <div class="col-md-12">

                            <label class="kepada" id="label_kepada"></label>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_kepada" id="notadinas_kepada">
                              </select>
                            </div><br>


                            <b>Dari</b>
                            <div class="input-group mb-1">
                              <select class="form-control select-pegawai" name="notadinas_dari" id="notadinas_dari">
                              </select>
                            </div><br>



                          <label for="notadinas_tanggal">Tanggal Surat</label>
                          <input class="form-control" type="date" id="notadinas_tanggal" name="notadinas_tanggal"><br>



                            <label for="notadinas_tanggal">Jenis Surat</label>
                        <select name="notadinas_jenissurat" id="notadinas_jenissurat" class="form-control">
                            <option value="">Pilih Jenis Surat</option>
                            @foreach ($jenissurat as $jenis)
                                <option value="{{ $jenis->jenissurat_id }}">{{ $jenis->kode_surat }}</option>
                            @endforeach
                        </select><br>

                        <label>Format Nomor Surat</label>
                          <input type="text" class="form-control" name="notadinas_format" id="notadinas_format">
                          <label>Contoh: /BKPP/DASI.KHP.1/823/12/2021 (tanpa Nomor Surat)</label><br><br>


                          <label>Lampiran</label>
                          <input type="text" class="form-control" name="notadinas_lampiran" id="notadinas_lampiran" value="-"><br>

                          <label>Hal</label>
                          ​<textarea id="notadinas_hal" name="notadinas_hal" rows="2" cols="53"></textarea><br>

                          <label>Isi Surat</label>
                          ​<textarea id="notadinas_isi" name="notadinas_isi" rows="5" cols="53"></textarea><br>

                          <label>Tujuan Perjalanan</label>
                          ​<textarea id="notadinas_tujuan" name="notadinas_tujuan" rows="2" cols="53"></textarea><br>

                          <label for="notadinas_tanggaldari">Dari Tanggal</label>
                          <input class="form-control" type="date" id="notadinas_tanggaldari" name="notadinas_tanggaldari">

                          <label for="notadinas_tanggalsampai">Sampai Tanggal</label>
                          <input class="form-control" type="date" id="notadinas_tanggalsampai" name="notadinas_tanggalsampai"><br>

                          <label>Anggaran yang dipakai</label>
                          ​<textarea id="notadinas_anggaran" name="notadinas_anggaran" rows="2" cols="53"></textarea><br>

                          <b>Pendisposisi Pertama</b>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_disposisi1" id="notadinas_disposisi1">
                              </select>
                            </div>

                            <b>Pendisposisi Kedua</b>
                            <div class="input-group mb-1">
                              <select class="form-control select-jabatan" name="notadinas_disposisi2" id="notadinas_disposisi2">
                              </select>
                            </div><br>

                        </div>


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

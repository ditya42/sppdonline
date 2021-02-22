<!-- Default Size -->
<div class="modal fade" id="modalnotadinas" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg" role="document">
      <form id="form-input" class="form-horizontal" data-toggle="validator" method="post">
      {{ csrf_field() }} {{ method_field('POST') }}
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="title" id="modalnotadinas-label"></h4>
          </div>
              <div class="modal-body">
                <input type="hidden" id="id" name="id">
                <div class="row">

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Kepada</label>
                        <input type="text" class="form-control" name="bidang_nama" id="bidang_nama">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Dari</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Nomor</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Sifat</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Hal</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Berangkat</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Tanggal Kembali</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Lama Perjalanan</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="form-group">
                        <label>Pegawai</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Tujuan</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Jenis</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Mengetahui</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="form-group">
                        <label>Untuk</label>
                        <input class="form-control curency" name="bidang_anggaran" id="bidang_anggaran">
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
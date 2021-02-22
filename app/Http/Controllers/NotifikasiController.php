<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use App\Pegawai;
use App\Model\SKP\TargetTahunan;
use DataTables;
use JsValidator;
use App\Model\SKP\TargetSKPTahunan;
use App\Model\SKP\TugasTambahanTahunan;
use App\Model\SKP\Kreatifitas;

class NotifikasiController extends Controller
{
    public function authpegawai()
    {
        $userid = auth()->user()->pegawai_id;
        return $userid;
    }

    // Notifikasi skp tahunan bawahan ke atasan : target tahunan, realisasi tahunan
    public function notifskpbulanan()
    {
        $id = $this->authpegawai();

        // Query menampilkan notifikasi target skp tahunan
        $query = TargetSKPTahunan::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_targetskptahunan.updated_at');
        // Query menampilkan notifikasi tugas tambahan tahunan
        $querytugastambahantahunan = TugasTambahanTahunan::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_tugastambahantahunan.created_at');
        // Query menampilkan notifikasi kreatifitas
        $querykreatifitas = Kreatifitas::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_kreatifitas.created_at');

        // Keluarkan data
        $getquery = $query->get();
        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Keluarkan data
        $getquerytugastambahan = $querytugastambahantahunan->get();
        foreach($getquerytugastambahan as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Keluarkan data
        $getquerykreatifitas = $querykreatifitas->get();
        foreach($getquerykreatifitas as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataverifikasi = $getquery
            ->where('targetskptahunan_status','Verifikasi')
            ->where('targetskptahunan_readatasan',0);

        // Data realisasi skp tahunan bawahan ke atasan untuk jumlah data
        $dataverifikasi_realisasi_skp_tahunan = $getquery
            ->where('targetskptahunan_realisasi_status','Verifikasi')
            ->where('targetskptahunan_realisasi_readatasan	',0);

        // Data tugas tambahan tahunan untuk jumlah data
        $datatugastambahan = $getquerytugastambahan
            ->where('tugastambahantahunan_status','Verifikasi')
            ->where('tugastambahantahunan_readatasan	',0);

        // Data kreatifitas untuk jumlah data
        $datakreatifitas = $getquerykreatifitas
        ->where('kreatifitas_status','Verifikasi')
        ->where('kreatifitas_readatasan	',0);

        // Jika dataverifikasi datanya ada
        if($dataverifikasi->count())
        {
            // Menampilkan target skp tahunan
            $datamessage = $getquery
            ->where('targetskptahunan_status','Verifikasi')
            ->where('targetskptahunan_readatasan',0);
        } else {
            // Menampilkan realisasi skp tahunan
            $datamessage = $getquery
            ->where('targetskptahunan_realisasi_status','Verifikasi')
            ->where('targetskptahunan_realisasi_readatasan	',0);
        }

        // Jumlah target skp tahunan bawahan yang masih verifikasi
        $target = $dataverifikasi->count();
        // Jumlah realisasi skp tahunan bawahan yang masih verifikasi
        $realisasi = $dataverifikasi_realisasi_skp_tahunan->count();
        // Jumlah tugas tambahan tahunan
        $tugastambahan = $datatugastambahan->count();
        // Jumlah kreatifitas
        $kreatifitas = $datakreatifitas->count();
        // Total dari nilai diatas
        $count = $target+$realisasi+$tugastambahan+$kreatifitas;

        $data = array();

        // Jika ada data pesan target skp tahunan dan realisasi skp tahunan
        if($datamessage->count())
        {
          foreach($datamessage->slice(0, 3) as $list) {
            $data[] =
            '<a class="dropdown-verifikasi" onclick="readnotifikasi('.$list->targetskptahunan_id.')">
                <div class="media">
                    <div class="media-left">
                        <i class="icon-info text-warning"></i>
                    </div>
                    <div class="media-body">
                    <p style="font-size: 12px;">'.namaGelar($list).'</p>
                    <p style="font-size: 12px;"> Status SKP Tahunan '.$list->targetskptahunan_status.'</p>
                    <p style="font-size: 12px;"> Target Tahunan : '.$list->targetskptahunan_kegiatan.'</p>
                    </div>
                </div>
            </a>';
          }
        } else if($datatugastambahan->count()) { // Jika tidak ada maka notif dibawah ini
          $data[] =
            '<a class="dropdown-verifikasi" onclick="readnotifikasiall()">
                <div class="media">
                    <div class="media-left">
                        <i class="icon-info text-warning"></i>
                    </div>
                    <div class="media-body">
                    <p style="font-size: 12px;">Anda Memiliki Notifikasi Tugas Tambahan dan Nilai Kreatifitas Dari Bawahan</p>
                    </div>
                </div>
            </a>';
        } else if($datakreatifitas->count()) {
          $data[] =
          '<a class="dropdown-verifikasi" onclick="readnotifikasiall()">
              <div class="media">
                  <div class="media-left">
                      <i class="icon-info text-warning"></i>
                  </div>
                  <div class="media-body">
                  <p style="font-size: 12px;">Anda Memiliki Notifikasi Tugas Tambahan dan Nilai Kreatifitas Dari Bawahan</p>
                  </div>
              </div>
          </a>';
        } else {
          $data[] = '';
        }

        $dataquery = array(
            'data_notifikasi'   => $data,
            'total_notifikasi' => $count
        );

        return response()->json($dataquery);
    }

    public function notifikasiAll()
    {
        return view('notifikasi.notifikasi_verifikasi');
    }

    // Data notifikasi target skp tahunan bawahan yang belim diverifikasi
    public function notifikasiBulanan()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun

        $query = TargetSKPTahunan::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_targetskptahunan.updated_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataverifikasi = $getquery->where('targetskptahunan_status','Verifikasi')->where('targetskptahunan_readatasan',0);

        $no = 0;
        $data = array();
        foreach($dataverifikasi as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='center'>$list->pegawai_nip</div>";
          $row[] = "<div align='left'>".namaGelar($list)."</div>";
          $row[] = "<div align='left'>$list->targetskptahunan_kegiatan</div>";
          $row[] = "<div align='center' style='color: #fff;'>
                   <a href='".route('verifikasitargetskptahunan.index')."' class='btn btn-success btn-sm'>
                    <i class='glyphicon glyphicon-edit'></i> Cek
                   </a>
                   </div>
                   ";
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    // Data notifikasi realisasi skp tahunan bawahan yang belum diverifikasi
    public function notifikasi_data_realisasi_tahunan()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun

        $query = TargetSKPTahunan::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_targetskptahunan.updated_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataverifikasi = $getquery->where('targetskptahunan_realisasi_status','Verifikasi')->where('targetskptahunan_realisasi_readatasan',0);

        $no = 0;
        $data = array();
        foreach($dataverifikasi as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='center'>$list->pegawai_nip</div>";
          $row[] = "<div align='left'>".namaGelar($list)."</div>";
          $row[] = "<div align='left'>$list->targetskptahunan_kegiatan</div>";
          $row[] = "<div align='center' style='color: #fff;'>
                   <a href='".route('verifikasitargetskptahunan.verifikasi_index_realisasi')."' class='btn btn-success btn-sm'>
                    <i class='glyphicon glyphicon-edit'></i> Cek
                   </a>
                   </div>
                   ";
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    // Notifikasi tugas tambahan dari bawahan ke atasan
    // Data nontifikasi tugas tambahan bawahan ke atasan yang belum verifikasi
    public function notifikasi_data_tugastambahan_tahunan_atasan()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun

        $query = TugasTambahanTahunan::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_tugastambahantahunan.created_at');

        $getquery = $query->get();


        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataquery = $getquery->where('tugastambahantahunan_status','Verifikasi')->where('tugastambahantahunan_readatasan',0);
        $no = 0;
        $data = array();
        foreach($dataquery as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='center'>$list->pegawai_nip</div>";
          $row[] = "<div align='left'>".namaGelar($list)."</div>";
          $row[] = "<div align='left'>$list->tugastambahantahunan_nama</div>";
          $row[] = "<div align='center' style='color: #fff;'>
                   <a href='".route('verifikasitugastambahantahunan.verifikasi_index_tugastambahan_tahunan')."' class='btn btn-success btn-sm'>
                    <i class='glyphicon glyphicon-edit'></i> Cek
                   </a>
                   </div>
                   ";
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    // Notifikasi kreatifitas dari bawahan ke atasan
    // Data nontifikasi kreatifitas bawahan ke atasan yang belum verifikasi
    public function notifikasi_data_kreatifitas_atasan()
    {
        $id = $this->authpegawai();

        $query = Kreatifitas::joinnotifikasi()->where('kinerja_targettahunan.targettahunan_pejabat1', $id)->orderBy('kinerja_kreatifitas.created_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataquery = $getquery->where('kreatifitas_status','Verifikasi')->where('kreatifitas_readatasan',0);
        $no = 0;
        $data = array();
        foreach($dataquery as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='center'>$list->pegawai_nip</div>";
          $row[] = "<div align='left'>".namaGelar($list)."</div>";
          $row[] = "<div align='left'>$list->kreatifitas_nama</div>";
          $row[] = "<div align='center' style='color: #fff;'>
                    <a href='".route('verifikasikreatifitas.verifikasi_index_kreatifitas')."' class='btn btn-success btn-sm'>
                    <i class='glyphicon glyphicon-edit'></i> Cek
                    </a>
                    </div>
                    ";
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    // Notif dari atasan ke bawahan
    public function notifskptahunan_pegawai()
    {
        $id = $this->authpegawai();

        // Query menampilkan notifikasi target skp tahunan
        $query = TargetSKPTahunan::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_targetskptahunan.updated_at');

        // Query menampilkan notifikasi tugas tambahan tahunan
        $querytugastambahantahunan = TugasTambahanTahunan::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_tugastambahantahunan.created_at');
        // Query menampilkan notifikasi kreatifitas
        $querykreatifitas = Kreatifitas::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_kreatifitas.created_at');
        // Keluarkan data
        $getquery = $query->get();
        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Keluarkan data
        $getquerytugastambahan = $querytugastambahantahunan->get();
        foreach($getquerytugastambahan as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Keluarkan data
        $getquerykreatifitas = $querykreatifitas->get();
        foreach($getquerykreatifitas as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataverifikasi = $getquery->where('targetskptahunan_readpegawai', 0);

        // Data tugas tambahan tahunan untuk jumlah data
        $datatugastambahan = $getquerytugastambahan
            ->where('tugastambahantahunan_readpegawai', 0);

        // Data kreatifitas untuk jumlah data
        $datakreatifitas = $getquerykreatifitas
            ->where('kreatifitas_readpegawai', 0);

        // Jika dataverifikasi datanya ada
        if($dataverifikasi->count())
        {
            $datamessage = $getquery->where('targetskptahunan_readpegawai', 0);
        } else {
            $datamessage = $getquery->where('targetskptahunan_realisasi_readpegawai', 0);
        }

        // Jumlah target skp tahunan pegawai yang masih verifikasi
        $target = $dataverifikasi->count();
        // Jumlah realisasi skp tahunan pegawai yang masih verifikasi
        $realisasi = $getquery->where('targetskptahunan_realisasi_readpegawai', 0)->count();
        // Jumlah tugas tambahan tahunan
        $tugastambahan = $datatugastambahan->count();
        // Jumlah kreatifitas
        $kreatifitas = $datakreatifitas->count();
        // Total dari nilai diatas
        $count = $target+$realisasi+$tugastambahan+$kreatifitas;

        $data = array();
        if($datamessage->count())
        {
          foreach($datamessage->slice(0, 3) as $list) {
            $data[] =
                    '<a class="dropdown-verifikasi kliksaja" onclick="notifikasi_read_skptahunan_pegawai('.$list->targettahunan_id.')">
                        <div class="media">
                            <div class="media-left">
                                <i class="icon-info text-warning"></i>
                            </div>
                            <div class="media-body">
                            <p style="font-size: 12px;">'.namaGelar($list).'</p>
                            <p style="font-size: 12px;"> Status SKP Tahunan '.$list->targetskptahunan_status.'</p>
                            <p style="font-size: 12px;"> Target Tahunan : '.$list->targetskptahunan_kegiatan.'</p>
                            </div>
                        </div>
                    </a>';
          }
        } else if ($datatugastambahan->count()) {
          $data[] = '<a class="dropdown-verifikasi" onclick="notifikasi_read_pegawai()">
              <div class="media">
                  <div class="media-left">
                      <i class="icon-info text-warning"></i>
                  </div>
                  <div class="media-body">
                  <p style="font-size: 12px;">Anda Memiliki Notifikasi Tugas Tambahan dan Nilai Kreatifitas Dari Atasan</p>
                  </div>
              </div>
          </a>';
        } else if($datakreatifitas->count()) {
          $data[] =
          '<a class="dropdown-verifikasi" onclick="readnotifikasiall()">
              <div class="media">
                  <div class="media-left">
                      <i class="icon-info text-warning"></i>
                  </div>
                  <div class="media-body">
                  <p style="font-size: 12px;">Anda Memiliki Notifikasi Tugas Tambahan dan Nilai Kreatifitas Dari Bawahan</p>
                  </div>
              </div>
          </a>';
        } else {
          $data[] = '';
        }

        $dataquery = array(
            'data_notifikasi_pegawai_skp_tahunan'   => $data,
            'total_notifikasi_pegawai_skp_tahunan' => $count
           );

        return response()->json($dataquery);
    }

    // Function untuk membaca skp tahunan pegawai dari atasan

    // Semua notifikasi skp tahunan dari atasan ke bawahan
    public function notifikasi_targetskp_tahunan_pegawai()
    {
        return view('notifikasi.notifikasi_targetskp_tahunan_pegawai');
    }

    // Ambil data notifikasi skp tahunan
    public function data_notifikasi_targetskp_tahunan_pegawai()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun
        $query = TargetSKPTahunan::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_targetskptahunan.updated_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataverifikasi = $getquery->where('targetskptahunan_readpegawai',0);

        $no = 0;
        $data = array();
        foreach($dataverifikasi as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='left'>$list->targetskptahunan_kegiatan</div>";
          if($list->targetskptahunan_status == 'Verifikasi')
          {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-info btn-sm'>Verifikasi</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>-</div>
                   ";
          } else if ($list->targetskptahunan_status == 'Tolak')
          {
            $row[] = "<center><a onclick='komentar_skptahunan_pegawai(".$list->targetskptahunan_id.")' style='color: #fff; width: 70px;' class='btn btn-danger btn-sm'>Tolak</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_skptahunan_pegawai(".$list->targetskptahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          } else if ($list->targetskptahunan_status == 'Revisi')
          {
            $row[] = "<center><a onclick='komentar_skptahunan_pegawai(".$list->targetskptahunan_id.")' style='color: #fff; width: 70px;' class='btn btn-warning btn-sm'>Revisi</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='cek_skptahunan_pegawai(".$list->targettahunan_id.")' class='btn btn-success btn-sm'>
                        <i class='glyphicon glyphicon-edit'></i>
                      </a>
                      <a onclick='read_skptahunan_pegawai(".$list->targetskptahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          } else {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-success btn-sm'>Terima</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_skptahunan_pegawai(".$list->targetskptahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          }
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function read_skptahunan_pegawai($id)
    {
        $db = TargetSKPTahunan::find($id);
        $db->targetskptahunan_readpegawai = 1;
        $db->save();
    }

    // Ambil data notifikasi realisasi skp tahunan
    public function data_notifikasi_realisasiskp_tahunan_pegawai()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun
        $query = TargetSKPTahunan::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_targetskptahunan.updated_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataverifikasi = $getquery->where('targetskptahunan_realisasi_readpegawai',0);

        $no = 0;
        $data = array();
        foreach($dataverifikasi as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='left'>$list->targetskptahunan_kegiatan</div>";
          if($list->targetskptahunan_realisasi_status == 'Verifikasi')
          {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-info btn-sm'>Verifikasi</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>-</div>
                   ";
          }  else if ($list->targetskptahunan_realisasi_status == 'Revisi')
          {
            $row[] = "<center><a onclick='komentar_skprealisasitahunan_pegawai(".$list->targetskptahunan_id.")' style='color: #fff; width: 70px;' class='btn btn-warning btn-sm'>Revisi</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='cek_skprealisasitahunan_pegawai(".$list->targettahunan_id.")' class='btn btn-success btn-sm'>
                        <i class='glyphicon glyphicon-edit'></i>
                      </a>
                      <a onclick='read_skprealisasitahunan_pegawai(".$list->targetskptahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          } else {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-success btn-sm'>Terima</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_skprealisasitahunan_pegawai(".$list->targetskptahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          }
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function read_skprealisasitahunan_pegawai($id)
    {
        $db = TargetSKPTahunan::find($id);
        $db->targetskptahunan_realisasi_readpegawai = 1;
        $db->save();
    }

    // Ambil data notifikasi tugas tambahan tahunan dari atasan ke bawahan
    public function data_notifikasi_tugastambahan_tahunan_pegawai()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun
        $query = TugasTambahanTahunan::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_tugastambahantahunan.created_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataquery = $getquery->where('tugastambahantahunan_readpegawai', 0);

        $no = 0;
        $data = array();
        foreach($dataquery as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='left'>$list->tugastambahantahunan_nama</div>";
          if($list->tugastambahantahunan_status == 'Verifikasi')
          {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-info btn-sm'>Verifikasi</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>-</div>
                   ";
          }  else if ($list->tugastambahantahunan_status == 'Tolak')
          {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-danger btn-sm'>Tolak</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_tugastambahantahunan_pegawai(".$list->tugastambahantahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          } else {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-success btn-sm'>Terima</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_tugastambahantahunan_pegawai(".$list->tugastambahantahunan_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          }
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function read_tugastambahantahunan_pegawai($id)
    {
        $db = TugasTambahanTahunan::find($id);
        $db->tugastambahantahunan_readpegawai = 1;
        $db->save();
    }

    // Ambil data notifikasi kreatifitas tahunan dari atasan ke bawahan
    public function data_notifikasi_kreatifitas()
    {
        $id = $this->authpegawai();

        // Bug tampilkan tahun
        $query = Kreatifitas::joinnotifikasi()->where('kinerja_targettahunan.pegawai_id', $id)->orderBy('kinerja_kreatifitas.created_at');

        $getquery = $query->get();

        foreach($getquery as $list)
        {
            $gettahun = $list->targettahunan_akhir;
            $list->tahun = Carbon::createFromFormat('Y-m-d', $gettahun)->year;
        }

        // Tahun sekarang
        $tahunsekarang = Carbon::now();
        $tahun = $tahunsekarang->year;

        // Mengeluarkan data dari query di atas
        $dataquery = $getquery->where('kreatifitas_readpegawai', 0);

        $no = 0;
        $data = array();
        foreach($dataquery as $list) {
          $no ++;
          $row = array();
          $row[] = "<div align='center'>$no</div>";
          $row[] = "<div align='left'>$list->kreatifitas_nama</div>";
          if($list->kreatifitas_status == 'Verifikasi')
          {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-info btn-sm'>Verifikasi</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>-</div>
                   ";
          }  else if ($list->kreatifitas_status == 'Tolak')
          {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-danger btn-sm'>Tolak</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_kreatifitas_pegawai(".$list->kreatifitas_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          } else {
            $row[] = "<center><a style='color: #fff; width: 70px;' class='btn btn-success btn-sm'>Terima</a></center>";
            $row[] = "<div align='center' style='color: #fff;'>
                      <a onclick='read_kreatifitas_pegawai(".$list->kreatifitas_id.")' class='btn btn-primary btn-sm'>
                        <i class='icon-check'></i>
                      </a>
                      </div>
                      ";
          }
          $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function read_kreatifitas_pegawai($id)
    {
        $db = Kreatifitas::find($id);
        $db->kreatifitas_readpegawai = 1;
        $db->save();
    }


}

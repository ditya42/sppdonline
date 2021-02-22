<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PegawaiKontrak extends Model
{
    protected $table = 'tb_pegawaikontrak';
    protected $primaryKey = 'pegawaikontrak_id';

    public function agama()
    {
        return $this->belongsTo('App\Model\Master\Agama', 'agama_id');
    }

    public function provinsi()
    {
        return $this->belongsTo('App\Model\Master\Provinsi', 'provinsi_id');
    }

    public function kabupaten()
    {
        return $this->belongsTo('App\Model\Master\Kabupaten', 'kabupaten_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo('App\Model\Master\Kecamatan', 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo('App\Model\Master\Kelurahan', 'kelurahan_id');
    }

    public function statuspegawai()
    {
        return $this->belongsTo('App\Model\Master\StatusPegawai', 'statuspegawai_id');
    }

    public function jenjang()
    {
        return $this->belongsTo('App\Model\Master\Jenjang', 'jenjang_id');
    }

    public function statusnikah()
    {
        return $this->belongsTo('App\Model\Master\StatusNikah', 'statusnikah_id');
    }

    public function skpd()
    {
        return $this->belongsTo('App\Model\Master\SKPD', 'skpd_id');
    }

    public function subunit()
    {
        return $this->belongsTo('App\Model\Master\SubUnit', 'subunit_id');
    }

    public function pendidikanpegawai()
    {
      return $this->belongsTo('App\PendidikanPegawai', 'pendidikan_id');
    }

    public static function joinall($id)
    {
        $x = DB::table('tb_pegawaikontrak')
            ->leftJoin('tb_agama', 'tb_pegawaikontrak.agama_id', '=', 'tb_agama.agama_id')
            ->leftJoin('tb_jenjang', 'tb_pegawaikontrak.jenjang_id', '=', 'tb_jenjang.jenjang_id')
            ->leftJoin('tb_statusnikah', 'tb_pegawaikontrak.statusnikah_id', '=', 'tb_statusnikah.statusnikah_id')
            ->leftJoin('tb_subunit', 'tb_pegawaikontrak.subunit_id','=','tb_subunit.subunit_id')
            ->leftJoin('tb_skpd', 'tb_pegawaikontrak.skpd_id','=','tb_skpd.skpd_id')
            ->leftJoin('tb_kelurahan', 'tb_pegawaikontrak.kelurahan_id', '=', 'tb_kelurahan.kelurahan_id')
            ->leftJoin('tb_kecamatan', 'tb_kelurahan.kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')
            ->leftJoin('tb_kabupaten', 'tb_kecamatan.kabupaten_id', '=', 'tb_kabupaten.kabupaten_id')
            ->leftJoin('tb_provinsi', 'tb_kabupaten.provinsi_id', '=', 'tb_provinsi.provinsi_id')
            ->leftJoin('tb_jeniskontrak','tb_pegawaikontrak.jeniskontrak_id','=','tb_jeniskontrak.jeniskontrak_id')
            ->leftJoin('tb_jeniskontrakkeahlian', 'tb_pegawaikontrak.jeniskontrakkeahlian_id','=','tb_jeniskontrakkeahlian.jeniskontrakkeahlian_id')
            ->where('tb_pegawaikontrak.pegawaikontrak_id', $id)
            ->first();
        return $x;
    }

    public static function datakontrak()
    {
        $query = DB::table('tb_pegawaikontrak')
            ->where('pegawaikontrak_status', 'Aktif')
            ->get();
        return $query;
    }
}

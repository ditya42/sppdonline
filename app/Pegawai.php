<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB; // Ambil class DB
use App\Helpers\Collection;

class Pegawai extends Authenticatable
{
    use Notifiable;

    protected $table = 'tb_pegawai';
    protected $primaryKey = 'pegawai_id';

    public $roleInfo = null;

    public function getnamaGelarAttribute() {
        $nama = $this->pegawai_nama;
        if (! isNull($this->pegawai_gelardepan))
            $nama =  $this->pegawai_gelardepan . ' ' . $nama;
        if (! isNull($this->pegawai_gelarbelakang))
            $nama = $nama . ', ' . $this->pegawai_gelarbelakang;
        return $nama;
    }

    public function pegawaiRole($pegawai_id,$app_id) {
        if ($this->roleInfo)
            return $this->roleInfo;

        $data =  DB::table('tb_pegawai')
            ->join('tb_pegawai_role','tb_pegawai.pegawai_id','=','tb_pegawai_role.pegawai_id')
            ->join('tb_role','tb_pegawai_role.role_id','=','tb_role.role_id')
            ->where('tb_pegawai.pegawai_id',$pegawai_id)
            ->where('tb_role.app_id',$app_id)
            ->first();
            if (! $data)  {
                $this->roleInfo = new Collection([
                    'role_name'     => 'Pegawai',
                    'app_id'        =>  $app_id,
                    'role_level'    =>  4
                ]);
            } else {
                $this->roleInfo = new Collection($data);
            }

        return $this->roleInfo;
    }

    public static function joinall($id)
    {
        $x = DB::table('tb_pegawai')
            ->leftJoin('tb_agama', 'tb_pegawai.agama_id', '=', 'tb_agama.agama_id')
            ->leftJoin('tb_statuspegawai', 'tb_pegawai.statuspegawai_id', '=', 'tb_statuspegawai.statuspegawai_id')
            ->leftJoin('tb_jenjang', 'tb_pegawai.jenjang_id', '=', 'tb_jenjang.jenjang_id')
            ->leftJoin('tb_statusnikah', 'tb_pegawai.statusnikah_id', '=', 'tb_statusnikah.statusnikah_id')
            ->leftJoin('tb_jenisfungsional', 'tb_pegawai.jenisfungsional_id', '=', 'tb_jenisfungsional.jenisfungsional_id')
            ->leftJoin('tb_jabatan', 'tb_pegawai.jabatan_id', '=', 'tb_jabatan.jabatan_id')
            ->leftJoin('tb_golongan', 'tb_pegawai.golongan_id', '=', 'tb_golongan.golongan_id')
            ->leftJoin('tb_eselon', 'tb_pegawai.eselon_id', '=', 'tb_eselon.eselon_id')
            ->leftJoin('tb_jenisguru', 'tb_pegawai.jenisguru_id', '=', 'tb_jenisguru.jenisguru_id')
            ->leftJoin('tb_jeniskesehatan', 'tb_pegawai.jeniskesehatan_id', '=', 'tb_jeniskesehatan.jeniskesehatan_id')
            ->leftJoin('tb_subunit', 'tb_pegawai.subunit_id','=','tb_subunit.subunit_id')
            ->leftJoin('tb_skpd', 'tb_pegawai.skpd_id','=','tb_skpd.skpd_id')
            ->leftJoin('tb_kelurahan', 'tb_pegawai.kelurahan_id', '=', 'tb_kelurahan.kelurahan_id')
            ->leftJoin('tb_kecamatan', 'tb_kelurahan.kecamatan_id', '=', 'tb_kecamatan.kecamatan_id')
            ->leftJoin('tb_kabupaten', 'tb_kecamatan.kabupaten_id', '=', 'tb_kabupaten.kabupaten_id')
            ->leftJoin('tb_provinsi', 'tb_kabupaten.provinsi_id', '=', 'tb_provinsi.provinsi_id')
            ->where('tb_pegawai.pegawai_id', $id)
            ->first();
        return $x;
    }

    public function skpd()
    {
        return $this->belongsTo('App\SKPD','skpd_id');
    }

    public function subunit()
    {
        return $this->belongsTo('App\Model\Master\SubUnit', 'subunit_id');
    }

    public function scopeDataPegawai()
    {
        $data = DB::table('tb_pegawai')->where('pegawai_kedudukanpns','Aktif')->where('pegawai_type','pns')->get();

        return $data;
    }

    public function scopeDataPegawaiExport()
    {
        $data = DB::table('tb_pegawai')
            ->leftjoin('tb_subunit','tb_pegawai.subunit_id','=','tb_subunit.subunit_id')
            ->leftjoin('tb_skpd','tb_pegawai.skpd_id','=','tb_skpd.skpd_id')
            ->leftjoin('tb_jabatan','tb_pegawai.jabatan_id','=','tb_jabatan.jabatan_id')
            ->where('tb_pegawai.pegawai_kedudukanpns','Aktif')
            ->where('tb_pegawai.pegawai_type','pns')
            ->orderby('tb_pegawai.skpd_id','asc')
            ->orderby('tb_pegawai.subunit_id','asc')
            ->orderby('tb_pegawai.eselon_id','asc')
            ->orderby('tb_pegawai.golongan_id','asc');

        return $data;
    }

}

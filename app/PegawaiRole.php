<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;

class PegawaiRole extends Model
{
    protected $table = 'tb_pegawai_role';
    protected $primaryKey = 'pr_id';

    public function pegawai()
    {
        return $this->belongsTo('App\Pegawai','pegawai_id');
    }

    public function role()
    {
        return $this->belongsTo('App\Role','role_id');
    }

    public function app()
    {
        return $this->belongsTo('App\App','app_id');
    }

    public static function joinrole()
    {
      return DB::table('tb_pegawai_role')
        ->join('tb_pegawai','tb_pegawai_role.pegawai_id','=','tb_pegawai.pegawai_id')
        ->join('tb_skpd','tb_pegawai.skpd_id','=','tb_skpd.skpd_id')
        ->join('tb_role','tb_pegawai_role.role_id','=','tb_role.role_id')
        ->get();
    }

    //Join tabel pegawai dari tb kecamatan sampai provinsi
    public static function joinall($id)
    {
        $x = DB::table('tb_pegawai_role')
            ->join('tb_role', 'tb_pegawai_role.role_id','=','tb_role.role_id')
            ->join('tb_pegawai','tb_pegawai_role.pegawai_id','=','tb_pegawai.pegawai_id')
            ->where('tb_pegawai_role.pr_id', $id)
            ->first();
        // return response()->json($x);
        return $x;
    }
}

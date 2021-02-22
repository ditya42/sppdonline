<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use DB;

class Jabatan extends Model
{
    protected $table = 'tb_jabatan';
    protected $primaryKey = 'jabatan_id';

    //  Ini perlu supaya kada error mass asigment
    protected $fillable = [
        'jabatan_nama',
        'skpd_id',
        'subunit_id',
        'jenisfungsional_id',
        'eselon_id',
        'jabatan_kategori',
        'ft_id',
        'jabatan_parent_id',
        'jabatan_sortir',
    ];

    public function jenisfungsional()
    {
        return $this->belongsTo('App\Model\Master\JenisFungsional','jenisfungsional_id');
    }

    public function skpd()
    {
        return $this->belongsTo('App\Model\Master\SKPD','skpd_id');
    }

    public function subunit()
    {
        return $this->belongsTo('App\Model\Master\SubUnit','subunit_id');
    }

    public function eselon()
    {
        return $this->belongsTo('App\Model\Master\Eselon','eselon_id');
    }

    public function treejabatan() {
        return $this->hasMany('App\Model\Master\Jabatan','jabatan_parent_id','jabatan_id');
    }

    public static function joinall($id)
    {
        $x = DB::table('tb_jabatan')
            ->leftJoin('tb_jenisfungsional', 'tb_jabatan.jenisfungsional_id', '=', 'tb_jenisfungsional.jenisfungsional_id')
            ->leftJoin('tb_eselon', 'tb_jabatan.eselon_id', '=', 'tb_eselon.eselon_id')
            ->leftJoin('tb_subunit', 'tb_jabatan.subunit_id','=','tb_subunit.subunit_id')
            ->leftJoin('tb_skpd', 'tb_jabatan.skpd_id','=','tb_skpd.skpd_id')
            ->where('tb_jabatan.jabatan_id', $id)
            ->where('tb_jabatan.jabatan_status', 'Aktif')
            ->first();
        return $x;
    }

    public static function datajabatankosong()
    {
        return DB::table('tb_jabatan')
            ->leftJoin('tb_subunit','tb_jabatan.subunit_id','=','tb_subunit.subunit_id')
            ->leftJoin('tb_skpd','tb_jabatan.skpd_id','=','tb_skpd.skpd_id')
            ->leftJoin('tb_eselon','tb_jabatan.eselon_id','=','tb_eselon.eselon_id')
            ->where('tb_jabatan.jenisfungsional_id', 3)
            ->where('tb_jabatan.jabatan_status', 'Aktif')
            ->where('tb_skpd.skpd_status', 1)
            ->orderBy('tb_skpd.skpd_id','asc')
            ->orderBy('tb_subunit.subunit_id','asc')
            ->orderBy('tb_jabatan.eselon_id','asc')
            ->get();
    }
}

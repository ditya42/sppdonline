<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use DB;

class SubUnit extends Model
{
    protected $table = 'tb_subunit';
    protected $primaryKey = 'subunit_id';
    protected $fillable = [
        'skpd_id',
        'subunit_kd',
        'subunit_nama',
        'subunit_type',
        'subunit_kategori',
        'subunit_lat',
        'subunit_lng',
        'subunit_radius',
        'subunit_status',
        'subunit_sort'
    ];

    public static function joinSkpd(){
        return DB::table('tb_subunit')->join('tb_skpd','tb_subunit.skpd_id','=','tb_skpd.skpd_id');
    }

}

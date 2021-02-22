<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class SKPD extends Model
{
    protected $table = 'tb_skpd';
    protected $primaryKey = 'skpd_id';
    protected $fillable = [
        'skpd_kd_urusan',
        'skpd_kd_bidang',
        'skpd_kd_unit',
        'kecamatan_id',
        'skpd_nama',
        'skpd_singkatan',
        'skpd_desc',
        'skpd_address',
        'skpd_lat',
        'skpd_lng',
        'skpd_radius',
        'skpd_status',
        'skpd_sort'
    ];

    public function pegawai()
    {
        return $this->hasMany('App\Model\Master\Pegawai','skpd_id','pegawai_id');
    }
}

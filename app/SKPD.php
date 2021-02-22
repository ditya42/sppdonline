<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SKPD extends Model
{
    protected $table = 'tb_skpd';
    protected $primaryKey = 'skpd_id';

    public function pegawai()
    {
        return $this->hasMany('App\Pegawai','skpd_id','pegawai_id');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey='role_id';
    protected $table='tb_role';

    public function getNamaGelarAttribute() {
        $nama = $this->pegawai_nama;
        if (! isNull($this->pegawai_gelardepan))
            $nama =  $this->pegawai_gelardepan . ' ' . $nama;
        if (! isNull($this->pegawai_gelarbelakang))
            $nama = $nama . ', ' . $this->pegawai_gelarbelakang;
        return $nama;
    }
}

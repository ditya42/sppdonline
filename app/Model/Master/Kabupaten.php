<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $table = 'tb_kabupaten';
    protected $primaryKey = 'kabupaten_id';

    public function provinsi()
    {
        return $this->belongsTo('App\Model\Master\Provinsi','provinsi_id');
    }

    public function kecamatan()
    {
        return $this->hasMany('App\Model\Master\Kecamatan','kabupaten_id','kecamatan_id');
    }
}

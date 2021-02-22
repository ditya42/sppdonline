<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Kelurahan extends Model
{
    protected $table = 'tb_kelurahan';
    protected $primaryKey = 'kelurahan_id';

    public function kecamatan()
    {
        return $this->belongsTo('App\Model\Master\Kecamatan','kecamatan_id');
    }
}

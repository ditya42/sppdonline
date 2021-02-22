<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class GajiPokok extends Model
{
    protected $table = 'tb_gajipokok';
    protected $primaryKey = 'gajipokok_id';

    public function golongan() {
        return $this->belongsTo('App\Model\Master\Golongan','golongan_id');
    }
}

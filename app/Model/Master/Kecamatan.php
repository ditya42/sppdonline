<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'tb_kecamatan';
    protected $primaryKey = 'kecamatan_id';

    public function kabupaten()
    {
        return $this->belongsTo('App\Model\Master\Kabupaten','kabupaten_id');
    }
}

<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisKontrakKeahlian extends Model
{
    protected $table = 'tb_jeniskontrakkeahlian';
    protected $primaryKey = 'jeniskontrakkeahlian_id';

    public function jeniskontrak()
    {
        return $this->belongsTo('App\Model\Master\JenisKontrak','jeniskontrak_id');
    }
}

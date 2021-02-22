<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisKPII extends Model
{
    protected $table = 'tb_jeniskp2';
    protected $primaryKey = 'jeniskp2_id';

    public function jeniskp1(){
        return $this->belongsTo('App\Model\Master\JenisKPI','jeniskp1_id');
    }
}

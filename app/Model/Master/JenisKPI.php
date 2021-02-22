<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisKPI extends Model
{
    protected $table = 'tb_jeniskp1';
    protected $primaryKey = 'jeniskp1_id';

    public function jenisfungsional(){
        return $this->belongsTo('App\Model\Master\JenisFungsional','jenisfungsional_id');
    }
}

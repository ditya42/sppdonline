<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class StatusKontrakSKPD extends Model
{
    protected $table = 'tb_statuskontrakskpd';
    protected $primaryKey = 'statuskontrakskpd_id';

    public function skpd()
    {
        return $this->belongsTo('App\Model\Master\SKPD','skpd_id');
    }
}

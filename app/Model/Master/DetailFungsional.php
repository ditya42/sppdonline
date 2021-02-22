<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class DetailFungsional extends Model
{
    protected $table = 'tb_detailfungsional';
    protected $primaryKey = 'detailfungsional_id';

    public function jabatanfungsional()
    {
        return $this->belongsTo('App\Model\Master\JabatanFungsionalTertentu', 'jabatanfungsionaltertentu_id');
    }
}

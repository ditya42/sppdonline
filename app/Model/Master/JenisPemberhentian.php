<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisPemberhentian extends Model
{
    protected $table = 'tb_jenispemberhentian';
    protected $primaryKey = 'jenispemberhentian_id';
    protected $fillable = ['jenispemberhentian_nama'];
}

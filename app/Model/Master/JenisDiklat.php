<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisDiklat extends Model
{
    protected $table = 'tb_jenisdiklat';
    protected $primaryKey = 'jenisdiklat_id';
    protected $fillable = ['jenisdiklat_nama'];
}

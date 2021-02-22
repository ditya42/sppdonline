<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    protected $table = 'tb_jeniscuti';
    protected $primaryKey = 'jeniscuti_id';
    protected $fillable = ['jeniscuti_nama'];
}

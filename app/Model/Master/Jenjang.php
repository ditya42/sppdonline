<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Jenjang extends Model
{
    protected $table = 'tb_jenjang';
    protected $primaryKey = 'jenjang_id';
    protected $fillable = ['jenjang_nama'];
}

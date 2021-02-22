<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisGuru extends Model
{
    protected $table = 'tb_jenisguru';
    protected $primaryKey = 'jenisguru_id';
    protected $fillable = ['jenisguru_nama'];
}

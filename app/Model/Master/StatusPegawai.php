<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class StatusPegawai extends Model
{
    protected $table = 'tb_statuspegawai';
    protected $primaryKey = 'statuspegawai_id';
    protected $fillable = ['statuspegawai_nama'];
}

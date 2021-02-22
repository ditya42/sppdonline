<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    protected $table = 'tb_provinsi';
    protected $primaryKey = 'provinsi_id';
    protected $fillable = ['provinsi_nama'];
}

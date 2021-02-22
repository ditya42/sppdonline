<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Golongan extends Model
{
    protected $table = 'tb_golongan';
    protected $primaryKey = 'golongan_id';
    protected $fillable = ['golongan_kode', 'golongan_nama'];
}

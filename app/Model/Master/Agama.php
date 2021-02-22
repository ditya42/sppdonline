<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Agama extends Model
{
    protected $table = 'tb_agama';
    protected $primaryKey = 'agama_id';
    protected $fillable = ['agama_nama'];
}

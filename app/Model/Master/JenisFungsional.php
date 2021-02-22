<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class JenisFungsional extends Model
{
    protected $table = 'tb_jenisfungsional';
    protected $primaryKey = 'jenisfungsional_id';
    protected $fillable = ['jenisfungsional_nama','jenisfungsional_status'];
}

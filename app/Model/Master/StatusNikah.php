<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class StatusNikah extends Model
{
    protected $table = 'tb_statusnikah';
    protected $primaryKey = 'statusnikah_id';
    protected $fillable = ['statusnikah_nama'];
}

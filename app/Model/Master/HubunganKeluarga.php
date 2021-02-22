<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class HubunganKeluarga extends Model
{
    protected $table = 'tb_hubungankeluarga';
    protected $primaryKey = 'hubungankeluarga_id';
    protected $fillable = ['hubungankeluarga_nama'];
}

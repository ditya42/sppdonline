<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PengajuanSuratKeluar extends Model
{
    // use SoftDeletes;
    protected $table = 'sppd_draftsuratkeluar';
    protected $primaryKey = 'draftsuratkeluar_id';
    // protected $dates = ['deleted_at'];
}

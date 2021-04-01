<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratKeluar extends Model
{

    use SoftDeletes;
    protected $table = 'sppd_suratkeluar';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}

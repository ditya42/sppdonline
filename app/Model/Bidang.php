<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bidang extends Model
{
    use SoftDeletes;

    protected $table = 'sppd_bidang';
    protected $primaryKey = 'bidang_id';
    protected $dates = ['deleteed_at'];
}

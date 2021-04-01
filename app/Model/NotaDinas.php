<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotaDinas extends Model
{
    use SoftDeletes;
    protected $table = 'sppd_notadinas';
    protected $primaryKey = 'id';
    protected $dates = ['deleted_at'];
}

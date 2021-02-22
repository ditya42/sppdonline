<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;

class Eselon extends Model
{
    protected $table = 'tb_eselon';
    protected $primaryKey = 'eselon_id';
    protected $fillable = ['eselon_nama'];
}

<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use DB;

class Pengesah extends Model
{
    protected $table = 'tb_pengesah';
    protected $primaryKey = 'pengesah_id';

    public static function  joinpengesah($pengesah)
    {
        $x = DB::table('tb_pengesah')
        ->where('tb_pengesah.pengesah_id', '=', $pengesah)
        ->first();
        return $x;
    }
}

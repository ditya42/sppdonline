<?php

namespace App\Http\Controllers\SuperAdmin\Master;

use App\Http\Controllers\AdminSKPD\Master\SuratKeluarAdminSKPDController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\SuratKeluar;

class PermanenDeleteSuratKeluar extends Controller
{
    public function deletepermanen($id)
    {
        // dd($id);

        $suratkeluar = SuratKeluar::where('id', $id);
        $suratkeluar->forcedelete();
        // dd($suratkeluar);

        // DB::table('sppd_suratkeluar')->where('id', $id)->delete();



    }
}


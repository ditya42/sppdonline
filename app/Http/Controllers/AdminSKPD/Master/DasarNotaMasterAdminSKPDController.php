<?php

namespace App\Http\Controllers\AdminSKPD\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;

use App\Http\Requests\RequestPegawaiBerangkat;
use App\Model\Dasar;
use App\Model\DasarNota;
use App\Model\NotaDinas;
use App\Model\PegawaiBerangkat;
use App\SKPD;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Carbon\Carbon;

class DasarNotaMasterAdminSKPDController extends Controller
{
    public function index($id)
    {
        $cek = NotaDinas::where('id',$id)->first();

        return view('admin_skpd/master/notadinas/dasarnota/dasarnotadinas_index', [

            'notadinas' => $cek,
        ]);
    }

    public function data(Request $request)
    {

        $id = $request->input('id');
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $query = DB::table('sppd_dasarnota')
        ->leftJoin('sppd_dasar','sppd_dasarnota.id_dasar','=','sppd_dasar.id')

        ->where('id_notadinas', $id)
        ->select('peraturan', 'tentang', 'sppd_dasarnota.id AS sppd_id', 'id_notadinas')
        ->get();
        //dd($query);

        return DataTables::of($query)


            ->addColumn('action', function($data) {
                // dd($data);

                $querynotadinas = NotaDinas::where('id',$data->id_notadinas)->first();

                if($querynotadinas->nomor == null){
                    return '
                    <div style="color: #fff">
                        <center>


                            <a onclick="deleteData('.$data->sppd_id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                        </center>

                    </div>

                ';
                }else{
                    return '
                    <div style="color: #fff">


                    </div>

                ';
                }

            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }
}

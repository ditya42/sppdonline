<?php

namespace App\Http\Controllers\Pegawai;

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

class DasarNotaDinasController extends Controller
{
    public function index($id)
    {
        $cek = NotaDinas::where('id',$id)->first();

        return view('pegawai/notadinas/dasarnotadinas/dasarnotadinas_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'JsValidator2' => JsValidator::make($this->rulesCreate2(), $this->messages2()),
            'notadinas' => $cek,
        ]);
    }

    public function data(Request $request)
    {

        $id = $request->input('id');
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $query = DB::table('sppd_dasarnota')
        ->leftJoin('sppd_dasar','sppd_dasar.id','=','sppd_dasarnota.id_dasar')

        ->where('id_notadinas', $id)
        // ->select()
        ->get();
        // dd($query);

        return DataTables::of($query)


            ->addColumn('action', function($data) {
                // dd($data->id);
                return '
                    <div style="color: #fff">
                        <center>


                            <a onclick="deleteData('.$data->id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                        </center>

                    </div>

                ';
            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }

    public function rulesCreate()
    {
        $rules = [
            'dasarnotapilih_iddasar' => 'required',


        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'dasarnotapilih_iddasar.required' => 'Dasar Surat Harus Diisi',
        ];
    }




    public function rulesCreate2()
    {
        $rules = [
            'dasarnotabaru_peraturan' => 'required',
            'dasarnotabaru_tentang' => 'required',

        ];

        return $rules;
    }

    public function messages2()
    {
        return [
            'dasarnotabaru_peraturan.required' => 'Dasar Surat Harus Diisi',
            'dasarnotabaru_tentang.required' => 'Tentang Dasar Surat Harus Diisi',
        ];
    }

    public function apidasar(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("sppd_dasar")

                    ->select('id','peraturan')
            		->where('peraturan','LIKE',"%$search%")
            		->get();
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {

        $cek=DB::table('sppd_dasarnota')->where(array(

            'id_notadinas' => $request['dasarnotapilih_notadinas'],

            'id_dasar' => $request['dasarnotapilih_iddasar'],

            ))

            ->first();


            if($cek != NULL) {
                return response()->json(['code'=>400, 'status' => 'Dasar Surat Sudah Ada'], 200);
            } else {
                $db = new DasarNota();
                $db->id_notadinas = $request['dasarnotapilih_notadinas'];
                $db->id_dasar = $request['dasarnotapilih_iddasar'];

                $db->save();
                return response()->json(['code'=>200, 'status' => 'Pegawai Berhasil Disimpan'], 200);

            }

        //


    }

    public function storebaru(Request $request)
    {

        $cek=DB::table('sppd_dasar')->where(array(

            'peraturan' => $request['dasarnotabaru_peraturan'],

            ))

            ->first();


            if($cek != NULL) {
                return response()->json(['code'=>400, 'status' => 'Dasar Surat Sudah Terdaftar'], 200);
            } else {

                $user = auth()->user();

                $dasar = new Dasar();
                $dasar->peraturan = $request['dasarnotabaru_peraturan'];
                $dasar->tentang = $request['dasarnotabaru_tentang'];
                $dasar->skpd = $user->skpd_id;
                $dasar->save();

                $db = new DasarNota();
                $db->id_notadinas = $request['dasarnotabaru_notadinas'];
                $db->id_dasar = $dasar->id;

                $db->save();
                return response()->json(['code'=>200, 'status' => 'Pegawai Berhasil Disimpan'], 200);

            }

        //


    }
}

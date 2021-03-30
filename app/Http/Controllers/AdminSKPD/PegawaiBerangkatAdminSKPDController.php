<?php

namespace App\Http\Controllers\AdminSKPD;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;

use App\Http\Requests\RequestPegawaiBerangkat;
use App\Model\Dasar;
use App\Model\NotaDinas;
use App\Model\PegawaiBerangkat;
use App\SKPD;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Carbon\Carbon;

class PegawaiBerangkatAdminSKPDController extends Controller
{
    public function index($id)
    {
        $cek = NotaDinas::where('id',$id)->first();

        return view('admin_skpd/surat/notadinas/pegawaiberangkat/pegawaiberangkat_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'notadinas' => $cek,
        ]);


    }

    public function data(Request $request)
    {

        $id = $request->input('id');
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $query = DB::table('sppd_pegawaiberangkat')
        ->leftJoin('tb_pegawai','tb_pegawai.pegawai_id','=','sppd_pegawaiberangkat.id_pegawai')
        ->leftJoin('tb_jabatan','tb_jabatan.jabatan_id','=','tb_pegawai.jabatan_id')
        ->where('id_notadinas', $id)
        // ->select()
        ->get();
        // dd($query);



        return DataTables::of($query)

        ->editColumn('nama_gelar', function($data) {
            if($data->pegawai_gelardepan =="-" AND $data->pegawai_gelarbelakang =="-"){
                return $data->pegawai_nama;
            }else if($data->pegawai_gelardepan !="-" AND $data->pegawai_gelarbelakang =="-"){
                return $data->pegawai_gelardepan.' '. $data->pegawai_nama;
            }else if($data->pegawai_gelardepan =="-" AND $data->pegawai_gelarbelakang !="-")
                return $data->pegawai_nama . ' ' . $data->pegawai_gelarbelakang;
            else{
                return $data->pegawai_gelardepan.' '. $data->pegawai_nama . ' ' . $data->pegawai_gelarbelakang;
            }

        })
            ->addColumn('action', function($data) {
                // dd($data->id);
                $querynotadinas = NotaDinas::where('id',$data->id_notadinas)->first();

                if($querynotadinas->nomor == null){
                    return '
                    <div style="color: #fff">
                        <center>


                            <a onclick="deleteData('.$data->id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

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

    public function rulesCreate()
    {
        $rules = [
            'pegawaiberangkat_idpegawai' => 'required',


        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'pegawaiberangkat_idpegawai.required' => 'Pegawai Yang Berangkat Harus Diisi',




        ];
    }

    public function store(Request $request)
    {

        $cek=DB::table('sppd_pegawaiberangkat')->where(array(

            'id_notadinas' => $request['pegawaiberangkat_notadinas'],

            'id_pegawai' => $request['pegawaiberangkat_idpegawai'],

            ))

            ->first();


            if($cek != NULL) {
                return response()->json(['code'=>400, 'status' => 'Data Pegawai Sudah Ada'], 200);
            } else {
                $db = new PegawaiBerangkat();
                $db->id_notadinas = $request['pegawaiberangkat_notadinas'];
                $db->id_pegawai = $request['pegawaiberangkat_idpegawai'];

                $db->save();
                return response()->json(['code'=>200, 'status' => 'Pegawai Berhasil Disimpan'], 200);

            }

        //


    }

    public function destroy($id)
    {
        $cek = PegawaiBerangkat::where('id',$id)->first();

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->back();
    }

}

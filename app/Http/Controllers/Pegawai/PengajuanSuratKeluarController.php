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
use App\Model\Master\Jabatan;
use App\Model\NotaDinas;
use App\Model\PegawaiBerangkat;
use App\Model\PengajuanSuratKeluar;
use App\Model\SuratKeluar;
use App\SKPD;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Carbon\Carbon;

class PengajuanSuratKeluarController extends Controller
{
    public function index()
    {
        $jenissurat = JenisSurat::all();
        return view('pegawai.pengajuansuratkeluar.pengajuansuratkeluar_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'jenissurat' => $jenissurat,
        ]);
    }

    public function data()
    {
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $user = auth()->user();

        $query = DB::table('sppd_draftsuratkeluar')
        ->leftJoin('sppd_jenissurat','sppd_draftsuratkeluar.jenis_surat','=','sppd_jenissurat.jenissurat_id')
        ->leftJoin('tb_jabatan','sppd_draftsuratkeluar.kepada','=','tb_jabatan.jabatan_id')

        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_draftsuratkeluar.created_at','desc')
        ->where('pembuat', $user->pegawai_id)
        ->get();
        // dd($query);

        return DataTables::of($query)

            ->addColumn('action', function($data) {
                if($data->nomor){

                return '
                    <div style="color: #fff">
                        <center>




                            <a onclick="showForm('.$data->draftsuratkeluar_id.')" class="btn btn-success btn-sm"><i class="fa fa-eye"> Show</i></a>


                        </center>

                    </div>

                ';

                }else{
                    return '
                    <div style="color: #fff">
                        <center>






                            <a onclick="setujui('.$data->draftsuratkeluar_id.')" class="btn btn-sm btn-success"><i class="fa fa-hand-pointer-o"> Daftarkan</i></a>



                            <a onclick="editForm('.$data->draftsuratkeluar_id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"> Edit</i></a>

                            <a onclick="deleteData('.$data->draftsuratkeluar_id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                        </center>

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
            'suratkeluar_kepada' => 'required',
            'suratkeluar_tanggal' =>'required',
            'suratkeluar_jenissurat' => 'required',
            'suratkeluar_format' => 'required',
            'suratkeluar_hal' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'suratkeluar_kepada.required' => 'Tujuan Surat Wajib Diisi.',
            'suratkeluar_tanggal.required' =>'Tanggal surat wajib diisi',
            'suratkeluar_jenissurat.required' =>'Jenis surat wajib diisi',
            'suratkeluar_format.required' =>'Format nomor surat wajib diisi',
            'suratkeluar_hal.required' =>'Hal wajib diisi',
        ];
    }


    public function store(Request $request)
    {

        $year = Carbon::now()->format('Y');
        $user = auth()->user();


            $db = new PengajuanSuratKeluar;

            $db->jenis_surat = $request['suratkeluar_jenissurat'];
            $db->format_nomor = $request['suratkeluar_format'];
            $db->kepada = $request['suratkeluar_kepada'];
            $db->tanggal = $request['suratkeluar_tanggal'];
            $db->perihal = $request['suratkeluar_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;
            $db->pembuat = $user->pegawai_id;

            $db->save();

            return response()->json(['code'=>200, 'status' => 'Draft Surat Keluar berhasil ditambahkan'], 200);


    }
}

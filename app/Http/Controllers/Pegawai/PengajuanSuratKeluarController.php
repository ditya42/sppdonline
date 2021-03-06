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
        $month =  Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $jenissurat = JenisSurat::all();
        return view('pegawai.pengajuansuratkeluar.pengajuansuratkeluar_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'jenissurat' => $jenissurat,
            'month' => $month,
            'year' => $year
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

        $month =  Carbon::now()->format('m');


            $db = new PengajuanSuratKeluar;

            $db->jenis_surat = $request['suratkeluar_jenissurat'];
            $db->format_nomor = "/".$request['suratkeluar_format']."/".$month."/".$year;
            $db->kepada = $request['suratkeluar_kepada'];
            $db->tanggal = $request['suratkeluar_tanggal'];
            $db->perihal = $request['suratkeluar_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;
            $db->pembuat = $user->pegawai_id;

            $db->save();

            return response()->json(['code'=>200, 'status' => 'Draft Surat Keluar berhasil ditambahkan'], 200);


    }

    public function edit($id)
    {
        $db = DB::table('sppd_draftsuratkeluar')


            ->where('draftsuratkeluar_id', $id)
            ->first();

        // dd($db);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {

        $year = Carbon::now()->format('Y');
        $user = auth()->user();

        $db = PengajuanSuratKeluar::find($id);
        // dd($db);


            $db->jenis_surat = $request['suratkeluaredit_jenissurat'];
            $db->format_nomor = $request['suratkeluaredit_format'];
            $db->kepada = $request['suratkeluaredit_kepada'];
            $db->tanggal = $request['suratkeluaredit_tanggal'];
            $db->perihal = $request['suratkeluaredit_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;
            $db->pembuat = $user->pegawai_id;

            $db->update();

            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);



    }

    public function destroy($id)
    {
        $db = PengajuanSuratKeluar::find($id);

        $db->delete();

    }

    public function setujui($id)
    {
        $pengajuan = PengajuanSuratKeluar::where('draftsuratkeluar_id',$id)->first();

        // $cekPNS = PegawaiBerangkat::where('id_notadinas',$id)->first();

        // $cekDasar = DasarNota::where('id_notadinas',$id)->first();

        //dd($notadinas);
        if($pengajuan->nomor){
            return response()->json(['code'=>400, 'status' => 'Surat Sudah Terdaftar'], 200);
        }

        // if($cekPNS == null){
        //     return response()->json(['code'=>500, 'status' => 'Tidak Ada PNS Yang Berangkat'], 200);
        // }

        // if($cekDasar == null){
        //     return response()->json(['code'=>600, 'status' => 'Tidak Ada Dasar Surat'], 200);
        // }

        $cek = DB::table('sppd_suratkeluar')
            ->where('tahun', '=', $pengajuan->tahun)
            ->where('skpd', '=', $pengajuan->skpd)
            ->latest()
            ->first();

        // $pejabat = Jabatan::where('jabatan_id',$notadinas->kepada)->first();

            //dd($cek);
        $jenissurat = JenisSurat::where('jenissurat_id',$pengajuan->jenis_surat)->first();

        if($cek == null){
            $db = new SuratKeluar;
            $db->nomor = 1;
            $db->nomor_lengkap = $jenissurat->kode_surat . 1 . $pengajuan->format_nomor;
            $db->kepada = $pengajuan->kepada;
            $db->tanggal = $pengajuan->tanggal;
            $db->perihal = $pengajuan->perihal;
            $db->tahun = $pengajuan->tahun;
            $db->skpd = $pengajuan->skpd;
            $db->id_draft = $pengajuan->draftsuratkeluar_id;
            $db->format_nomor = $pengajuan->format_nomor;
            $db->jenis_surat = $pengajuan->jenis_surat;



            $db->save();

            $pengajuan->nomor = $db->nomor;
            $pengajuan->update();

            return response()->json(['code'=>200, 'status' => 'Surat Keluar berhasil dicatat ke Buku Surat Keluar'], 200);
        }else{
            $db = new SuratKeluar;
            $db->nomor = $cek->nomor+1;
            $cek1 = $cek->nomor+1;
            $db->nomor_lengkap = $jenissurat->kode_surat . $cek1 . $pengajuan->format_nomor;
            $db->kepada = $pengajuan->kepada;
            $db->tanggal = $pengajuan->tanggal;
            $db->perihal = $pengajuan->perihal;
            $db->tahun = $pengajuan->tahun;
            $db->skpd = $pengajuan->skpd;
            $db->id_draft = $pengajuan->draftsuratkeluar_id;
            $db->format_nomor = $pengajuan->format_nomor;
            $db->jenis_surat = $pengajuan->jenis_surat;

            $db->save();

            $pengajuan->nomor = $db->nomor;
            $pengajuan->update();
            return response()->json(['code'=>200, 'status' => 'Surat Keluar berhasil dicatat ke Buku Surat Keluar'], 200);
        }
    }

}

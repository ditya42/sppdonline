<?php

namespace App\Http\Controllers\Pegawai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\Dasar;
use App\Model\NotaDinas;
use App\SKPD;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Carbon\Carbon;



class NotaDinasPegawaiController extends Controller
{
    public function index()
    {
        $jenissurat = JenisSurat::all();
        return view('pegawai.notadinas.notadinas_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'jenissurat' => $jenissurat,
        ]);
    }

    public function data()
    {
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $user = auth()->user();

        $query = DB::table('sppd_notadinas')
        ->leftJoin('sppd_jenissurat','sppd_notadinas.jenis_surat','=','sppd_jenissurat.jenissurat_id')
        ->leftJoin('tb_jabatan','sppd_notadinas.kepada','=','tb_jabatan.jabatan_id')
        ->leftJoin('tb_pegawai','sppd_notadinas.penandatangan','=','tb_pegawai.pegawai_id')
        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_notadinas.created_at','desc')
        ->where('pembuat', $user->pegawai_id)
        ->get();
        // dd($query);

        return DataTables::of($query)

            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-odnoklassniki"> PNS Berangkat</i></a>
                        <a href="" class="btn btn-primary btn-sm"><i class="fa fa-book"> Dasar Surat</i></a>



                            <a href="" class="btn btn-sm btn-warning"><i class="fa fa-hand-pointer-o"> Daftarkan</i></a>

                            <a href="" class="btn btn-sm btn-warning"><i class="fa fa-print"> cetak</i></a>

                            <a onclick="editForm('.$data->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"> Edit</i></a>

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
            'notadinas_kepada' => 'required_without:id',
            'notadinas_dari' =>'required_without:id',
            'notadinas_tanggal' =>'required',
            'notadinas_jenissurat' =>'required',
            'notadinas_format' =>'required',
            'notadinas_hal' =>'required',
            'notadinas_isi' =>'required',
            'notadinas_tujuan' =>'required',
            'notadinas_tanggaldari' =>'required',
            'notadinas_tanggalsampai' =>'required',
            'notadinas_anggaran' =>'required',
            'notadinas_disposisi1' =>'required_without:id',

        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'notadinas_kepada.required_without:id' => 'Tujuan Surat Harus Diisi',
            'notadinas_dari.required' =>'Pengirim Surat Harus Diisi',
            'notadinas_tanggal.required' =>'Tanggal Surat Harus Diisi',
            'notadinas_jenissurat.required' =>'Jenis Surat Harus Diisi',
            'notadinas_format.required' =>'Format Nomor Surat Harus Diisi',
            'notadinas_hal.required' =>'Perihal Surat Harus Diisi',
            'notadinas_isi.required' =>'Isi Surat Tidak Boleh Kosong',
            'notadinas_tujuan.required' =>'Tujuan Surat Tidak Boleh kosong',
            'notadinas_tanggaldari.required' =>'Tanggal Berangkat Harus Diisi',
            'notadinas_tanggalsampai.required' =>'Tanggal Sampai Harus Diisi',
            'notadinas_anggaran.required' =>'Anggaran Harus Diisi',
            'notadinas_disposisi1.required' =>'Pendisposisi Harus Diisi',

        ];
    }

    public function apipegawai(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("tb_pegawai")
                    ->leftJoin('tb_jabatan','tb_pegawai.jabatan_id','=','tb_jabatan.jabatan_id')
                    ->select('pegawai_id','pegawai_nip', 'jabatan_nama', 'pegawai_nama')
            		->where('pegawai_nip','LIKE',"%$search%")
            		->get();
        }

        return response()->json($data);
    }

    public function apijabatan(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("tb_jabatan")

                    ->select('jabatan_id','jabatan_nama')
            		->where('jabatan_nama','LIKE',"%$search%")
            		->get();
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        //
        $user = auth()->user();
        $date = Carbon::now()->format('Y');

            $db = new NotaDinas;
            $db->tanggal_surat = $request['notadinas_tanggal'];
            $db->jenis_surat = $request['notadinas_jenissurat'];
            $db->format_nomor = $request['notadinas_format'];
            $db->lampiran = $request['notadinas_lampiran'];
            $db->hal = $request['notadinas_hal'];
            $db->isi = $request['notadinas_isi'];
            $db->tujuan = $request['notadinas_tujuan'];
            $db->tanggal_dari = $request['notadinas_tanggaldari'];
            $db->tanggal_sampai = $request['notadinas_tanggalsampai'];
            $db->anggaran = $request['notadinas_anggaran'];
            $db->penandatangan = $request['notadinas_dari'];
            $db->pembuat = $user->pegawai_id;
            $db->skpd = $user->skpd_id;
            $db->tahun = $date;
            $db->kepada = $request['notadinas_kepada'];
            $db->disposisi1 = $request['notadinas_disposisi1'];
            $db->disposisi2 = $request['notadinas_disposisi2'];


            $db->save();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }

    public function edit($id)
    {
        $db = DB::table('sppd_notadinas')

            ->leftJoin('tb_jabatan AS A','A.jabatan_id','=','sppd_notadinas.kepada')
            ->leftJoin('tb_jabatan AS B','B.jabatan_id','=','sppd_notadinas.disposisi1')
            ->leftJoin('tb_jabatan AS C','C.jabatan_id','=','sppd_notadinas.disposisi2')
            ->leftJoin('tb_jabatan AS D','D.jabatan_id','=','sppd_notadinas.penandatangan')

            ->select('A.jabatan_nama as jabatan_kepada', 'B.jabatan_nama as jabatan_disposisi1', 'C.jabatan_nama as jabatan_disposisi2','D.jabatan_nama as jabatan_dari', 'id', 'kepada', 'tanggal_surat', 'jenis_surat'
            ,'format_nomor','lampiran','hal','isi','tujuan','tanggal_dari','tanggal_sampai','anggaran')

            // ->leftJoin('tb_jabatan AS B','sppd_notadinas.disposisi1','=','B.jabatan_id')
            // ->leftJoin('tb_jabatan AS C','sppd_notadinas.disposisi2','=','C.jabatan_id')


        // ->orderBy('tb_skpd.skpd_nama','asc')
            // ->orderBy('sppd_notadinas.created_at','desc')
            ->where('id', $id)
            ->first();

        // dd($db);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $date = Carbon::now()->format('Y');

            $db = NotaDinas::find($id);
            $db->tanggal_surat = $request['notadinas_tanggal'];
            $db->jenis_surat = $request['notadinas_jenissurat'];
            $db->format_nomor = $request['notadinas_format'];
            $db->lampiran = $request['notadinas_lampiran'];
            $db->hal = $request['notadinas_hal'];
            $db->isi = $request['notadinas_isi'];
            $db->tujuan = $request['notadinas_tujuan'];
            $db->tanggal_dari = $request['notadinas_tanggaldari'];
            $db->tanggal_sampai = $request['notadinas_tanggalsampai'];
            $db->anggaran = $request['notadinas_anggaran'];
            $db->pembuat = $user->pegawai_id;
            $db->skpd = $user->skpd_id;
            $db->tahun = $date;

            if (!empty($request['notadinas_dari'])) {
                $db->penandatangan = $request['notadinas_dari'];
            }

            if (!empty($request['notadinas_kepada'])) {
                $db->kepada = $request['notadinas_kepada'];

            }

            if (!empty($request['notadinas_disposisi1'])) {
                $db->disposisi1 = $request['notadinas_disposisi1'];
            }

            if (!empty($request['notadinas_disposisi2'])) {
                $db->disposisi2 = $request['notadinas_disposisi2'];
            }


            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }

    public function destroy($id)
    {
        $cek = Dasar::where('id',$id)->first();

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->route('adminskpd.dasarsurat.index');
    }

}

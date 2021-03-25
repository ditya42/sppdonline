<?php

namespace App\Http\Controllers\AdminSKPD\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\SuratKeluar;
use Illuminate\Support\Carbon;
use JsValidator;

class SuratKeluarAdminSKPDController extends Controller
{
    public function index()
    {
        $jenissurat = JenisSurat::all();
        return view('admin_skpd.master.suratkeluar.suratkeluar_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'jenissurat' => $jenissurat,
        ]);
    }

    public function data()
    {
        $user = auth()->user();
        $query = DB::table('sppd_suratkeluar')

        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_suratkeluar.created_at','desc')
        ->where('skpd', $user->skpd_id)
        ->get();

        // dd($query);


        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>

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
            'jenissurat_nama' => 'required',
            'kode_surat' =>'required'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'jenissurat_nama.required' => 'Jenis Surat Wajib Diisi.',
            'kode_surat.required' =>'kode surat wajib diisi'
        ];
    }

    public function store(Request $request)
    {
        $year = Carbon::now()->format('Y');
        $user = auth()->user();

        $cek = DB::table('sppd_suratkeluar')
            ->where('tahun', '=', $year)
            ->where('skpd', '=', $user->skpd_id)
            ->latest()
            ->first();

        $jenissurat = $request['suratkeluar_jenissurat'];

        $kodesurat = JenisSurat::where('jenissurat_id',$jenissurat)->first();

        $format_nomor = $request['suratkeluar_format'];

        if($cek == null){
            $db = new SuratKeluar;
            $db->nomor = 1;
            $db->nomor_lengkap = $kodesurat->kode_surat . 1 . $format_nomor;
            $db->jenis_surat = $kodesurat->jenissurat_id;
            $db->format_nomor = $format_nomor;
            $db->kepada = $request['suratkeluar_kepada'];
            $db->tanggal = $request['suratkeluar_tanggal'];
            $db->perihal = $request['suratkeluar_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;

            $db->save();

            return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);
        }else{
            $db = new SuratKeluar;
            $db->nomor = $cek->nomor+1;
            $cek1 = $cek->nomor+1;
            $db->jenis_surat = $kodesurat->jenissurat_id;
            $db->format_nomor = $format_nomor;
            $db->nomor_lengkap = $kodesurat->kode_surat . $cek1 . $format_nomor;
            $db->kepada = $request['suratkeluar_kepada'];
            $db->tanggal = $request['suratkeluar_tanggal'];
            $db->perihal = $request['suratkeluar_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;

            $db->save();

            return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);
        }

    }

    public function edit($id)
    {
        $db = DB::table('sppd_suratkeluar')


            ->where('id', $id)
            ->first();

        // dd($db);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $year = Carbon::now()->format('Y');

        $db = SuratKeluar::find($id);

        $jenissurat = $request['suratkeluar_jenissurat'];

        $kodesurat = JenisSurat::where('jenissurat_id',$jenissurat)->first();

        $format_nomor = $request['suratkeluar_format'];


        $db->jenis_surat = $jenissurat;
        $db->format_nomor = $format_nomor;
        $db->nomor_lengkap = $kodesurat->kode_surat . $db->nomor . $format_nomor;
        $db->kepada = $request['suratkeluar_kepada'];
        $db->tanggal = $request['suratkeluar_tanggal'];
        $db->perihal = $request['suratkeluar_hal'];
        $db->tahun = $year;
        $db->skpd = $user->skpd_id;


            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }


}

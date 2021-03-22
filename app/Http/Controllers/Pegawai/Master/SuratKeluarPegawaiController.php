<?php

namespace App\Http\Controllers\Pegawai\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\SuratKeluar;
use JsValidator;

class SuratKeluarPegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.master.suratkeluar.suratkeluar_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
        ]);
    }

    public function data()
    {
        $user = auth()->user();
        $query = DB::table('sppd_suratkeluar')

        ->leftJoin('tb_jabatan','sppd_suratkeluar.kepada','=','tb_jabatan.jabatan_id')

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
}

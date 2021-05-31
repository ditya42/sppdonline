<?php

namespace App\Http\Controllers\Pegawai\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\SuratKeluar;
use Illuminate\Support\Carbon;
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
        $year = Carbon::now()->format('Y');
        $query = SuratKeluar::orderBy('created_at','desc')->where('skpd', $user->skpd_id)->where('tahun', $year);

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

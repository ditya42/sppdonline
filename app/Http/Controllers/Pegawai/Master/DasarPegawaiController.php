<?php

namespace App\Http\Controllers\Pegawai\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\Dasar;
use App\SKPD;
use Illuminate\Support\Facades\Auth;

use JsValidator;

class DasarPegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.master.dasarsurat.dasarsurat_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
        ]);
    }

    public function data()
    {
        $user = auth()->user();

        $query = DB::table('sppd_dasar')
        ->leftJoin('tb_skpd','sppd_dasar.skpd','=','tb_skpd.skpd_id')
        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_dasar.created_at','asc')
        ->where('skpd', $user->skpd_id)
        ->get();
        // dd($query);

        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                            <a onclick="editForm('.$data->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>

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
            'peraturan' => 'required',
            'tentang' =>'required'

        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'peraturan.required' => 'Peraturan Wajib Diisi.',
            'tentang.required' =>'Kolom Tentang Wajib diisi'

        ];
    }
}

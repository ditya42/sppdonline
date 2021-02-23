<?php

namespace App\Http\Controllers\Pegawai\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use JsValidator;

class JenisSuratPegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.master.jenissurat.jenissurat_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
        ]);
    }

    public function data()
    {
        $query = JenisSurat::orderBy('created_at');

        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                            <a onclick="editForm('.$data->jenissurat_id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>

                            <a onclick="deleteData('.$data->jenissurat_id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

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

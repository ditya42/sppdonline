<?php

namespace App\Http\Controllers\SuperAdmin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JenisTransportasi;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use JsValidator;

class JenisTransportasiController extends Controller
{
    public function index()
    {
        return view('super_admin.master.jenistransportasi.jenistransportasi_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
        ]);
    }

    public function data()
    {
        $query = JenisTransportasi::orderBy('transportasi_nama');

        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                            <a onclick="editForm('.$data->transportasi_id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
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
            'transportasi_nama' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'transportasi_nama.required' => 'Jenis Transportasi Wajib Diisi.',
        ];
    }

    public function store(Request $request)
    {
        $cek = JenisTransportasi::where('transportasi_nama', $request['transportasi_nama'])->first();

        if($cek != NULL) {
            return response()->json(['code'=>400, 'status' => 'Maaf Jenis Transportasi Sudah Ada'], 200);
        } else {
            $db = new JenisTransportasi;
            $db->transportasi_nama = $request['transportasi_nama'];
            $db->save();
            return response()->json(['code'=>200, 'status' => 'Jenis Transportasi Berhasil Disimpan'], 200);
        }
    }

    public function edit($id)
    {
        $db = JenisTransportasi::find($id);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $cek = JenisTransportasi::where('transportasi_nama', $request['transportasi_nama'])->first();

        if($cek != NULL && $cek->transportasi_id != $id) {
            return response()->json(['code'=>400, 'status' => 'Maaf Jenis Transportasi Sudah Ada'], 200);
        } else {
            $db = JenisTransportasi::find($id);
            $db->transportasi_nama = $request['transportasi_nama'];
            $db->update();
            return response()->json(['code'=>200, 'status' => 'Jenis Transportasi Berhasil Disimpan'], 200);
        }
    }

    public function destroy($id)
    {
        $db = JenisTransportasi::find($id);
        $db->delete();
    }
}

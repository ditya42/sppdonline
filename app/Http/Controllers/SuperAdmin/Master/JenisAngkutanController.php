<?php

namespace App\Http\Controllers\SuperAdmin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\JenisAngkutan;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use JsValidator;

class JenisAngkutanController extends Controller
{
    public function index()
    {
        return view('super_admin.master.jenisangkutan.jenisangkutan_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
        ]);
    }

    public function data()
    {
        $query = JenisAngkutan::orderBy('angkutan_nama');

        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                            <a onclick="editForm('.$data->angkutan_id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
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
            'angkutan_nama' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'angkutan_nama.required' => 'Jenis Angkutan Wajib Diisi.',
        ];
    }

    public function store(Request $request)
    {
        $cek = JenisAngkutan::where('angkutan_nama', $request['angkutan_nama'])->first();

        if($cek != NULL) {
            return response()->json(['code'=>400, 'status' => 'Maaf Jenis Angkutan Sudah Ada'], 200);
        } else {
            $db = new JenisAngkutan;
            $db->angkutan_nama = $request['angkutan_nama'];
            $db->save();
            return response()->json(['code'=>200, 'status' => 'Jenis Angkutan Berhasil Disimpan'], 200);
        }
    }

    public function edit($id)
    {
        $db = JenisAngkutan::find($id);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $cek = JenisAngkutan::where('angkutan_nama', $request['angkutan_nama'])->first();

        if($cek != NULL && $cek->angkutan_id != $id) {
            return response()->json(['code'=>400, 'status' => 'Maaf Jenis Angkutan Sudah Ada'], 200);
        } else {
            $db = JenisAngkutan::find($id);
            $db->angkutan_nama = $request['angkutan_nama'];
            $db->update();
            return response()->json(['code'=>200, 'status' => 'Jenis Angkutan Berhasil Disimpan'], 200);
        }
    }

    public function destroy($id)
    {
        $db = JenisAngkutan::find($id);
        $db->delete();
    }
}

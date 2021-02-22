<?php

namespace App\Http\Controllers\SuperAdmin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use JsValidator;

class JenisSuratController extends Controller
{
    public function index()
    {
        return view('super_admin.master.jenissurat.jenissurat_index', [
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

    public function store(Request $request)
    {
        $cek = JenisSurat::where('jenissurat_nama', $request['jenissurat_nama'])->first();

        if($cek != NULL) {
            return response()->json(['code'=>400, 'status' => 'Maaf Jenis Surat Sudah Ada'], 200);
        } else {
            $db = new JenisSurat;
            $db->jenissurat_nama = $request['jenissurat_nama'];
            $db->kode_surat = $request['kode_surat'];
            $db->save();
            return response()->json(['code'=>200, 'status' => 'Jenis Surat Berhasil Disimpan'], 200);
        }
    }

    public function edit($id)
    {
        $db = JenisSurat::find($id);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $cek = JenisSurat::where('jenissurat_nama', $request['jenissurat_nama'])->first();

        if($cek != NULL && $cek->jenissurat_id != $id) {
            return response()->json(['code'=>400, 'status' => 'Maaf Jenis Surat Sudah Ada'], 200);
        } else {
            $db = JenisSurat::find($id);
            $db->jenissurat_nama = $request['jenissurat_nama'];
            $db->kode_surat = $request['kode_surat'];
            $db->update();
            return response()->json(['code'=>200, 'status' => 'Jenis Surat Berhasil Disimpan'], 200);
        }
    }

    public function show($id){
        $db = JenisSurat::find($id);
        // $db->delete();
        // return view('super_admin.master.jenissurat.jenissurat_index');
    }

    public function destroy($id)
    {
        $cek = JenisSurat::where('jenissurat_id',$id)->first();

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->route('superadmin.jenissurat.index');
    }
}

<?php

namespace App\Http\Controllers\adminSKPD\Master;

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

class DasarAdminSKPDController extends Controller
{
    public function index()
    {
        $skpd = SKPD::all();
        // $user = auth()->user();
        // dd($user->skpd_id);

        return view('admin_skpd.master.dasarsurat.dasarsurat_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            "skpd"=>$skpd,
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

    public function store(Request $request)
    {
        $user = auth()->user();
        $cek = Dasar::where('peraturan', $request['peraturan'])->first();

        if($cek != NULL) {
            return response()->json(['code'=>400, 'status' => 'Maaf Dasar Surat Sudah Ada'], 200);
        } else {
            $db = new Dasar;
            $db->peraturan = $request['peraturan'];
            $db->tentang = $request['tentang'];
            $db->skpd = $user->skpd_id;
            $db->save();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);
        }
    }

    public function edit($id)
    {
        $db = Dasar::find($id);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $cek = Dasar::where('peraturan', $request['peraturan'])->first();

        if($cek != NULL && $cek->id != $id) {
            return response()->json(['code'=>400, 'status' => 'Maaf Dasar Surat Sudah Ada'], 200);
        } else {
            $db = Dasar::find($id);
            $db->peraturan = $request['peraturan'];
            $db->tentang = $request['tentang'];

            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);
        }
    }

    public function destroy($id)
    {
        $cek = Dasar::where('id',$id)->first();

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->route('adminskpd.dasarsurat.index');
    }


}

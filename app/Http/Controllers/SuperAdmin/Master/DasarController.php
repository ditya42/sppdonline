<?php

namespace App\Http\Controllers\SuperAdmin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\Dasar;
use App\SKPD;
use JsValidator;


class DasarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $skpd = SKPD::all();

        return view('super_admin.master.dasarsurat.dasarsurat_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            "skpd"=>$skpd,
        ]);
    }

    public function data()
    {
        $query = DB::table('sppd_dasar')
        ->leftJoin('tb_skpd','sppd_dasar.skpd','=','tb_skpd.skpd_id')
        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_dasar.created_at','asc')

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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rulesCreate()
    {
        $rules = [
            'peraturan' => 'required',
            'tentang' =>'required',
            'skpd' =>'required',
        ];

        return $rules;
    }


    public function messages()
    {
        return [
            'peraturan.required' => 'Peraturan Wajib Diisi.',
            'tentang.required' =>'Kolom Tentang Wajib diisi',
            'skpd.required' => 'Wajib pilih SKPD.',
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cek = Dasar::where('peraturan', $request['peraturan'])->first();

        if($cek != NULL) {
            return response()->json(['code'=>400, 'status' => 'Maaf Dasar Surat Sudah Ada'], 200);
        } else {
            $db = new Dasar;
            $db->peraturan = $request['peraturan'];
            $db->tentang = $request['tentang'];
            $db->skpd = $request['skpd'];
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
            $db->skpd = $request['skpd'];
            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cek = Dasar::where('id',$id)->first();

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->route('superadmin.dasarsurat.index');
    }
}

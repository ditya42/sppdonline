<?php

namespace App\Http\Controllers\AdminSKPD\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Bidang;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use JsValidator;

class BidangController extends Controller
{
    public function index()
    {
        return view('admin_skpd.master.bidang.bidang_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
        ]);
    }

    public function trash()
    {
        return view('admin_skpd.master.bidang.bidang_trash');
    }

    public function data()
    {
        $skpd = auth()->user()->skpd_id;
        $query = Bidang::orderBy('bidang_id')->where('skpd_id', $skpd);

        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                            <a onclick="editForm('.$data->bidang_id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                            <a onclick="hapus('.$data->bidang_id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </center>
                ';
            })
            ->editColumn('bidang_anggaran', function ($query) {
                return 'Rp. ' . formatRupiah($query->bidang_anggaran);
            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }

    public function datatrash()
    {
        $skpd = auth()->user()->skpd_id;
        $query = Bidang::orderBy('bidang_id')->where('skpd_id', $skpd)->onlyTrashed();

        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>
                            <a onclick="restore('.$data->bidang_id.')" class="btn btn-success btn-sm"><i class="fa fa-undo"></i></a>
                            <a onclick="hapuspermanent('.$data->bidang_id.')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                        </center>
                ';
            })
            ->editColumn('bidang_anggaran', function ($query) {
                return 'Rp. ' . formatRupiah($query->bidang_anggaran);
            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }

    public function rulesCreate()
    {
        $rules = [
            'bidang_nama' => 'required',
            'bidang_anggaran' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'bidang_nama.required' => 'Bidang Wajib Diisi.',
            'bidang_anggaran.required' => 'Anggaran Wajib Diisi.',
        ];
    }

    public function store(Request $request)
    {
        $cek = Bidang::where('bidang_nama', $request['bidang_nama'])->first();
        $skpd = auth()->user()->skpd_id;

        if($cek != NULL) {
            return response()->json(['code'=>400, 'status' => 'Maaf Bidang Sudah Ada'], 200);
        } else {
            $db = new Bidang;
            $db->bidang_nama = $request['bidang_nama'];
            $db->bidang_anggaran = $request['bidang_anggaran'];
            $db->skpd_id = $skpd;
            $db->save();
            return response()->json(['code'=>200, 'status' => 'Bidang Berhasil Disimpan'], 200);
        }
    }

    public function edit($id)
    {
        $db = Bidang::find($id);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $cek = Bidang::where('bidang_nama', $request['bidang_nama'])->first();
        $skpd = auth()->user()->skpd_id;

        if($cek != NULL && $cek->bidang_id != $id) {
            return response()->json(['code'=>400, 'status' => 'Maaf Bidang Sudah Ada'], 200);
        } else {
            $db = Bidang::find($id);
            $db->bidang_nama = $request['bidang_nama'];
            $db->bidang_anggaran = $request['bidang_anggaran'];
            $db->skpd_id = $skpd;
            $db->update();
            return response()->json(['code'=>200, 'status' => 'Bidang Berhasil Disimpan'], 200);
        }
    }

    public function hapus($id)
    {
        $db = Bidang::find($id);
        $db->delete();
    }

    public function hapuspermanent($id)
    {
        $db = Bidang::onlyTrashed()->where('bidang_id',$id);
        $db->forceDelete();
    }

    public function restore($id)
    {
    	$db = Bidang::onlyTrashed()->where('bidang_id',$id);
    	$db->restore();
    }
}

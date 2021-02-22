<?php

namespace App\Http\Controllers\SuperAdmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use FelixKiss;
use App\Pegawai;
use App\Role;
use App\PegawaiRole;
use App\ManajemenUser;

class ManajemenUserController extends Controller
{
    public function index()
    {
        return view('super_admin.manajemenuser.manajemenuser_index');
    }

    public function apipegawai(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("tb_pegawai")
                    ->leftJoin('tb_jabatan','tb_pegawai.jabatan_id','=','tb_jabatan.jabatan_id')
                    ->select('pegawai_id','pegawai_nip', 'jabatan_nama', 'pegawai_nama')
            		->where('pegawai_nip','LIKE',"%$search%")
            		->get();
        }

        return response()->json($data);
    }

    public function data()
    {
        $query = DB::table('tb_pegawai_role')
                ->join('tb_pegawai','tb_pegawai_role.pegawai_id','=','tb_pegawai.pegawai_id')
                ->join('tb_subunit','tb_pegawai.subunit_id','=','tb_subunit.subunit_id')
                ->join('tb_skpd','tb_pegawai.skpd_id','=','tb_skpd.skpd_id')
                ->join('tb_role','tb_pegawai_role.role_id','=','tb_role.role_id')
                ->where('tb_role.app_id', 16)
                ->where('tb_pegawai.pegawai_kedudukanpns','Aktif')
                ->get();

        $data = array();
        foreach($query as $list){
        $row = array();
        $row[] = $list->pegawai_nip;
        $row[] = $list->pegawai_nama;
        $row[] = $list->role_name;
        $row[] = $list->skpd_nama;
        $row[] = $list->subunit_nama;
        $row[] = ' <div align="center">
                    <a href="' . route('manajemenuser.edit', $list->pegawai_id) . '" class="btn btn-xs btn-success">
                        <i class="glyphicon glyphicon-edit"></i>
                    </a>
                    </div>
                ';
        $data[] = $row;
        }

        $output = array("data" => $data);
        return response()->json($output);
    }

    public function create()
    {
        return view('super_admin.manajemenuser.manajemenuser_create', [
            'roles' => Role::where('app_id', env('APP_ID'))->get()
        ]);
    }

    public function store(Request $request)
    {
        $pegawai_id = $request->pegawai_id;
        $pr = new PegawaiRole;
        $pr->pegawai_id = $pegawai_id;
        $pr->created_by = auth()->id();
        $pr->role_id = $request->role_id;

        if ($pr->save()) {
            alert()->success('User Berhasil Ditambah');
            return redirect()->route('manajemenuser.index');
        }
    }

    public function edit($id)
    {
        $data = PegawaiRole::joinall($id);
            return view('super_admin.manajemenuser.manajemenuser_edit', [
            'data' => $data,
            'roles' => Role::where('app_id', env('APP_ID'))->get(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $pr = PegawaiRole::where('pegawai_id', $id)->first();
        $pr->pegawai_id = $id;
        $pr->created_by = auth()->id();
        $pr->role_id = $request->role_id;

        if ($pr->update()) {
            alert()->success('User Berhasil Diupdate');
            return redirect()->route('manajemenuser.index');
        }
    }

    public function show($id)
    {

    }

    public function destroy($id)
    {
        $db = PegawaiRole::findOrFail($id);
        $db->delete();
    }
}

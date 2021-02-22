<?php

namespace App\Http\Controllers\AdminSKPD\Pegawai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Pegawai;
use DataTables;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('admin_skpd.pegawai.pegawai_index');
    }

    public function data()
    {
        $getskpd = auth()->user()->skpd_id;

        // Ambil query pegawai
        $query = Pegawai::with('skpd')
                ->where('pegawai_kedudukanpns', 'Aktif')
                ->where('pegawai_type', 'pns')
                ->where('skpd_id', $getskpd)
                ->where('subunit_id', 0)
                ->orderBy('skpd_id')
                ->orderBy('eselon_id');

        // return ke datatable
        return DataTables::eloquent($query)
            ->addColumn('action', function ($pegawai) {
                return '
                <div align="center">
                <a style="width: 72px;" href="' . route('pegawai.show', $pegawai->pegawai_id) . '" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Cek
                </a>
                ';
            })
            ->editColumn('pegawai_nama', function ($pegawai) {
                return strtoupper(namaGelar($pegawai));
            })
            ->toJson();
    }


    public function datasubunit()
    {
        $getskpd = auth()->user()->skpd_id;

         // Ambil query pegawai
         $query = Pegawai::with('skpd')
         ->with('subunit')
         ->where('pegawai_kedudukanpns', 'Aktif')
         ->where('pegawai_type', 'pns')
         ->where('skpd_id', $getskpd)
         ->where('subunit_id','!=', 0)
         ->orderBy('skpd_id')
         ->orderBy('eselon_id');

        // return ke datatable
        return DataTables::eloquent($query)
            ->addColumn('action', function ($pegawai) {
                return '
                <div align="center">
                <a style="width: 72px;" href="' . route('pegawai.show', $pegawai->pegawai_id) . '" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Cek
                </a>
                ';
            })
            ->editColumn('pegawai_nama', function ($pegawai) {
                return strtoupper(namaGelar($pegawai));
            })
            ->toJson();
    }

    // Menampilkan data pegawai berdasarkan id pegawai
    public function show($id)
    {
        $data = DB::table('tb_pegawai')->where('pegawai_id', $id)
                ->leftJoin('tb_jabatan','tb_pegawai.jabatan_id','=','tb_jabatan.jabatan_id')
                ->leftJoin('tb_golongan','tb_pegawai.golongan_id','=','tb_golongan.golongan_id')
                ->leftJoin('tb_subunit','tb_pegawai.subunit_id','=','tb_subunit.subunit_id')
                ->leftJoin('tb_skpd','tb_pegawai.skpd_id','=','tb_skpd.skpd_id')
                ->leftJoin('tb_agama','tb_pegawai.agama_id','=','tb_agama.agama_id')
                ->leftJoin('tb_statusnikah','tb_pegawai.statusnikah_id','=','tb_statusnikah.statusnikah_id')
                ->leftJoin('tb_eselon','tb_pegawai.eselon_id','=','tb_eselon.eselon_id')
                ->leftJoin('tb_jenjang','tb_pegawai.jenjang_id','=','tb_jenjang.jenjang_id')
                ->first();

        return view('admin_skpd.pegawai.pegawai_show',[
            'data' => $data
        ]);
    }
}

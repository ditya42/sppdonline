<?php

namespace App\Http\Controllers\AdminSKPD\Pegawai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
use App\PegawaiKontrak;
use Carbon\Carbon;

class PegawaiKontrakController extends Controller
{
    public function index()
    {
        return view('admin_skpd.pegawaikontrak.pegawaikontrak_index');
    }

    public function data()
    {
        $query = PegawaiKontrak::with('skpd')->where('pegawaikontrak_status', 'Aktif')->where('skpd_id', auth()->user()->skpd_id)->orderBy('skpd_id');

        // return ke datatable
        return DataTables::eloquent($query)
            ->addColumn('action', function ($pegawaikontrak) {
                return '
                    <div align="center">
                    <a style="width: 72px;" href="' . route('pegawaikontrak.show', $pegawaikontrak->pegawaikontrak_id) . '" class="btn btn-xs btn-primary">
                        <i class="glyphicon glyphicon-edit"></i> Cek
                    </a>
                ';
            })
            ->toJson();
    }

    public function show($id)
    {
        $data = PegawaiKontrak::joinall($id);
        $datafind = PegawaiKontrak::find($id);
        $getage = $data->pegawaikontrak_tanggallahir;
        $born = Carbon::parse($getage);
        $age = $born->diff(Carbon::now())->format('%y Tahun');
        $getmasakerja = $data->pegawaikontrak_tmtskawal;
        $masa = Carbon::parse($getmasakerja);
        $masakerja = $masa->diff(Carbon::now())->format('%y Tahun %m Bulan');
         return view('admin_skpd.pegawaikontrak.pegawaikontrak_show',[
            'datafind'        => $datafind,
            'data' => $data,
            'age' => $age,
            'masakerja' => $masakerja,
        ]);
    }
}

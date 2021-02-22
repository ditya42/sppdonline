<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pegawai;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userid = auth()->user()->pegawai_id;
        $pegawai = DB::table('tb_pegawai')->where('pegawai_id', $userid)->first();
        return view('dashboard_admin',[
            'pegawai' => $pegawai
        ]);
    }

    public function home()
    {
        return view('dashboard_admin');
    }

    public function profile()
    {
        $userid = auth()->user()->pegawai_id;
        $pegawai = DB::table('tb_pegawai')
                    ->join('tb_jabatan','tb_pegawai.jabatan_id','=','tb_jabatan.jabatan_id')
                    ->join('tb_subunit','tb_pegawai.subunit_id','=','tb_subunit.subunit_id')
                    ->join('tb_skpd','tb_pegawai.skpd_id','=','tb_skpd.skpd_id')
                    ->join('tb_golongan','tb_pegawai.golongan_id','=','tb_golongan.golongan_id')
                    ->where('pegawai_id', $userid)
                    ->first();

        return view('profile', [
            'pegawai' => $pegawai
        ]);
    }

    public function updateprofile(Request $request, $id)
    {
            $db = Pegawai::find($id);

            if($request->email) {
                $db->pegawai_email = $request->email;
            }

            if($db->save()) {
              alert()->success('Password Berhasil Disimpan');
              return redirect()->back();
            }
    }
}

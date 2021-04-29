<?php

namespace App\Http\Controllers\Pegawai;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;

use App\Http\Requests\RequestPegawaiBerangkat;
use App\Model\Dasar;
use App\Model\DasarNota;
use App\Model\Master\Jabatan;
use App\Model\NotaDinas;
use App\Model\PegawaiBerangkat;
use App\Model\SuratKeluar;
use App\Pegawai;
use App\SKPD;
use Illuminate\Support\Facades\Auth;
use JsValidator;
use Carbon\Carbon;
use PhpOffice\PhpWord\Template;
use PhpOffice\PhpWord\TemplateProcessor;

class NotaDinasPegawaiController extends Controller
{
    public function index()
    {
        $jenissurat = JenisSurat::all();
        return view('pegawai.notadinas.notadinas_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'jenissurat' => $jenissurat,
        ]);
    }

    public function data()
    {
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $user = auth()->user();

        $query = DB::table('sppd_notadinas')
        ->leftJoin('sppd_jenissurat','sppd_notadinas.jenis_surat','=','sppd_jenissurat.jenissurat_id')
        ->leftJoin('tb_jabatan','sppd_notadinas.kepada','=','tb_jabatan.jabatan_id')
        ->leftJoin('tb_pegawai','sppd_notadinas.penandatangan','=','tb_pegawai.pegawai_id')
        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_notadinas.created_at','desc')
        ->where('pembuat', $user->pegawai_id)
        ->get();
        // dd($query);

        return DataTables::of($query)

            ->addColumn('action', function($data) {
                if($data->nomor){

                return '
                    <div style="color: #fff">
                        <center>

                        <a href="' .route('pegawaiberangkat',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-odnoklassniki"> PNS Berangkat</i></a>
                        <a href="' .route('dasarnotadinas.index',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-book"> Dasar Surat</i></a>
                            <a href="' .route('pegawainotadinas.cetak',$data->id). '" class="btn btn-sm btn-warning"><i class="fa fa-print"> cetak</i></a>
                            <a onclick="showForm('.$data->id.')" class="btn btn-success btn-sm"><i class="fa fa-eye"> Show</i></a>


                        </center>

                    </div>

                ';

                }else{
                    return '
                    <div style="color: #fff">
                        <center>


                        <a href="' .route('pegawaiberangkat',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-odnoklassniki"> PNS Berangkat</i></a>
                        <a href="' .route('dasarnotadinas.index',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-book"> Dasar Surat</i></a>



                            <a onclick="setujui('.$data->id.')" class="btn btn-sm btn-success"><i class="fa fa-hand-pointer-o"> Daftarkan</i></a>

                            <a href="' .route('pegawainotadinas.cetak',$data->id). '" class="btn btn-sm btn-warning"><i class="fa fa-print"> cetak</i></a>

                            <a onclick="editForm('.$data->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"> Edit</i></a>

                            <a onclick="deleteData('.$data->id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                        </center>

                    </div>

                ';
                }
            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }

    public function rulesCreate()
    {
        $rules = [
            'notadinas_kepada' => 'required_without:id',
            'notadinas_dari' =>'required_without:id',
            'notadinas_tanggal' =>'required',
            'notadinas_jenissurat' =>'required',
            'notadinas_format' =>'required',
            'notadinas_hal' =>'required',
            'notadinas_isi' =>'required',
            'notadinas_tujuan' =>'required',
            'notadinas_tanggaldari' =>'required',
            'notadinas_tanggalsampai' =>'required',
            'notadinas_anggaran' =>'required',
            'notadinas_disposisi1' =>'required_without:id',

        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'notadinas_kepada.required_without' => 'Tujuan Surat Harus Diisi',
            'notadinas_dari.required_without' => 'Harus Diisi',
            'notadinas_disposisi1.required_without' => 'Pejabat Pemberi Disposisi Harus Diisi',

            'notadinas_dari.required' =>'Pengirim Surat Harus Diisi',
            'notadinas_tanggal.required' =>'Tanggal Surat Harus Diisi',
            'notadinas_jenissurat.required' =>'Jenis Surat Harus Diisi',
            'notadinas_format.required' =>'Format Nomor Surat Harus Diisi',
            'notadinas_hal.required' =>'Perihal Surat Harus Diisi',
            'notadinas_isi.required' =>'Isi Surat Tidak Boleh Kosong',
            'notadinas_tujuan.required' =>'Tujuan Surat Tidak Boleh kosong',
            'notadinas_tanggaldari.required' =>'Tanggal Berangkat Harus Diisi',
            'notadinas_tanggalsampai.required' =>'Tanggal Sampai Harus Diisi',
            'notadinas_anggaran.required' =>'Anggaran Harus Diisi',



        ];
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

    public function apijabatan(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("tb_jabatan")

                    ->select('jabatan_id','jabatan_nama')
            		->where('jabatan_nama','LIKE',"%$search%")
            		->get();
        }

        return response()->json($data);
    }

    public function store(Request $request)
    {
        //
        $user = auth()->user();
        $date = Carbon::now()->format('Y');

            $db = new NotaDinas;
            $db->tanggal_surat = $request['notadinas_tanggal'];
            $db->jenis_surat = $request['notadinas_jenissurat'];
            $db->format_nomor = $request['notadinas_format'];
            $db->lampiran = $request['notadinas_lampiran'];
            $db->hal = $request['notadinas_hal'];
            $db->isi = $request['notadinas_isi'];
            $db->tujuan = $request['notadinas_tujuan'];
            $db->tanggal_dari = $request['notadinas_tanggaldari'];
            $db->tanggal_sampai = $request['notadinas_tanggalsampai'];
            $db->anggaran = $request['notadinas_anggaran'];
            $db->penandatangan = $request['notadinas_dari'];
            $db->pembuat = $user->pegawai_id;
            $db->skpd = $user->skpd_id;
            $db->tahun = $date;
            $db->kepada = $request['notadinas_kepada'];
            $db->disposisi1 = $request['notadinas_disposisi1'];
            $db->disposisi2 = $request['notadinas_disposisi2'];


            $db->save();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }

    public function edit($id)
    {
        $db = DB::table('sppd_notadinas')

            ->leftJoin('tb_jabatan AS A','A.jabatan_id','=','sppd_notadinas.kepada')
            ->leftJoin('tb_jabatan AS B','B.jabatan_id','=','sppd_notadinas.disposisi1')
            ->leftJoin('tb_jabatan AS C','C.jabatan_id','=','sppd_notadinas.disposisi2')
            ->leftJoin('tb_jabatan AS D','D.jabatan_id','=','sppd_notadinas.penandatangan')

            ->select('A.jabatan_nama as jabatan_kepada', 'B.jabatan_nama as jabatan_disposisi1', 'C.jabatan_nama as jabatan_disposisi2','D.jabatan_nama as jabatan_dari', 'id', 'kepada', 'tanggal_surat', 'jenis_surat'
            ,'format_nomor','lampiran','hal','isi','tujuan','tanggal_dari','tanggal_sampai','anggaran')

            // ->leftJoin('tb_jabatan AS B','sppd_notadinas.disposisi1','=','B.jabatan_id')
            // ->leftJoin('tb_jabatan AS C','sppd_notadinas.disposisi2','=','C.jabatan_id')


        // ->orderBy('tb_skpd.skpd_nama','asc')
            // ->orderBy('sppd_notadinas.created_at','desc')
            ->where('id', $id)
            ->first();

        // dd($db);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $date = Carbon::now()->format('Y');

            $db = NotaDinas::find($id);
            $db->tanggal_surat = $request['notadinas_tanggal'];
            $db->jenis_surat = $request['notadinas_jenissurat'];
            $db->format_nomor = $request['notadinas_format'];
            $db->lampiran = $request['notadinas_lampiran'];
            $db->hal = $request['notadinas_hal'];
            $db->isi = $request['notadinas_isi'];
            $db->tujuan = $request['notadinas_tujuan'];
            $db->tanggal_dari = $request['notadinas_tanggaldari'];
            $db->tanggal_sampai = $request['notadinas_tanggalsampai'];
            $db->anggaran = $request['notadinas_anggaran'];
            $db->pembuat = $user->pegawai_id;
            $db->skpd = $user->skpd_id;
            $db->tahun = $date;

            if (!empty($request['notadinas_dari'])) {
                $db->penandatangan = $request['notadinas_dari'];
            }

            if (!empty($request['notadinas_kepada'])) {
                $db->kepada = $request['notadinas_kepada'];

            }

            if (!empty($request['notadinas_disposisi1'])) {
                $db->disposisi1 = $request['notadinas_disposisi1'];
            }

            if (!empty($request['notadinas_disposisi2'])) {
                $db->disposisi2 = $request['notadinas_disposisi2'];
            }


            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }

    public function destroy($id)
    {
        $cek = NotaDinas::where('id',$id)->first();

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->route('pegawai.notadinas.index');
    }


    public function setujui($id)
    {
        $notadinas = NotaDinas::where('id',$id)->first();

        $cekPNS = PegawaiBerangkat::where('id_notadinas',$id)->first();

        $cekDasar = DasarNota::where('id_notadinas',$id)->first();

        //dd($notadinas);
        if($notadinas->nomor){
            return response()->json(['code'=>400, 'status' => 'Surat Sudah Terdaftar'], 200);
        }

        if($cekPNS == null){
            return response()->json(['code'=>500, 'status' => 'Tidak Ada PNS Yang Berangkat'], 200);
        }

        if($cekDasar == null){
            return response()->json(['code'=>600, 'status' => 'Tidak Ada Dasar Surat'], 200);
        }

        $cek = DB::table('sppd_suratkeluar')
            ->where('tahun', '=', $notadinas->tahun)
            ->where('skpd', '=', $notadinas->skpd)
            ->latest()
            ->first();

        $pejabat = Jabatan::where('jabatan_id',$notadinas->kepada)->first();

            //dd($cek);
        $jenissurat = JenisSurat::where('jenissurat_id',$notadinas->jenis_surat)->first();

        if($cek == null){
            $db = new SuratKeluar;
            $db->nomor = 1;
            $db->nomor_lengkap = $jenissurat->kode_surat . 1 . $notadinas->format_nomor;
            $db->kepada = $pejabat->jabatan_nama;
            $db->tanggal = $notadinas->tanggal_surat;
            $db->perihal = "Nota Dinas untuk " . $notadinas->Hal;
            $db->tahun = $notadinas->tahun;
            $db->skpd = $notadinas->skpd;
            $db->id_notadinas = $notadinas->id;
            $db->format_nomor = $notadinas->format_nomor;
            $db->jenis_surat = $notadinas->jenis_surat;



            $db->save();

            $notadinas->nomor = $db->nomor;
            $notadinas->update();

            return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);
        }else{
            $db = new SuratKeluar;
            $db->nomor = $cek->nomor+1;
            $cek1 = $cek->nomor+1;
            $db->nomor_lengkap = $jenissurat->kode_surat . $cek1 . $notadinas->format_nomor;
            $db->kepada = $pejabat->jabatan_nama;
            $db->tanggal = $notadinas->tanggal_surat;
            $db->perihal = "Nota Dinas untuk " . $notadinas->Hal;
            $db->tahun = $notadinas->tahun;
            $db->skpd = $notadinas->skpd;
            $db->id_notadinas = $notadinas->id;
            $db->format_nomor = $notadinas->format_nomor;
            $db->jenis_surat = $notadinas->jenis_surat;

            $db->save();

            $notadinas->nomor = $db->nomor;
            $notadinas->update();
            return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);
        }


    }

    public function cetak ($id)
    {
        $notadinas = NotaDinas::findOrFail($id);

        $kepada = Jabatan::where('jabatan_id',$notadinas->kepada)->first();

        $dari = DB::table('tb_pegawai')
        ->leftJoin('tb_jabatan','tb_pegawai.jabatan_id','=','tb_jabatan.jabatan_id')
        ->where('pegawai_id', '=', $notadinas->penandatangan)
        ->first();
        // dd($dari);

        $pegawaiberangkat = PegawaiBerangkat::where('id_notadinas',$id)->first();

        $dasarnota = DasarNota::where('id_notadinas',$id)->first();

        $jenissurat = JenisSurat::where('jenissurat_id',$notadinas->jenis_surat)->first();

        // $kodesurat = Dasar::findOrFail($jenissurat);

        if($pegawaiberangkat == null){
            return redirect()->back()->with('alert', 'Tidak ada Pegawai Berangkat');
        }

        if($dasarnota == null){
            return redirect()->back()->with('alert', 'Tidak ada Dasar Surat');
        }

        //dd($id);


        $nip = Pegawai::findOrFail($pegawaiberangkat->id_pegawai);

        // dd($nip);
        $tanggal = tanggal_indonesia_huruf($notadinas->tanggal_surat);

        $penandatangan = Pegawai::findOrFail($notadinas->penandatangan);

        $templateProcessor = new TemplateProcessor('template/BKPP_single.docx');
        $templateProcessor->setValue('kepada', $kepada->jabatan_nama);
        $templateProcessor->setValue('dari', $dari->jabatan_nama);
        $templateProcessor->setValue('tanggal', $tanggal);
        $templateProcessor->setValue('jenis_surat', $jenissurat->kode_surat);
        $templateProcessor->setValue('nomor', $notadinas->nomor);
        $templateProcessor->setValue('format_nomor', $notadinas->format_nomor);
        $templateProcessor->setValue('lampiran', $notadinas->lampiran);
        $templateProcessor->setValue('perihal', $notadinas->Hal);
        $templateProcessor->setValue('dasar_surat', $dasarnota->id_dasar);
        $templateProcessor->setValue('nama_pegawai', $pegawaiberangkat->id_pegawai);
        $templateProcessor->setValue('nip', $nip->pegawai_nip);
        $templateProcessor->setValue('golongan', $nip->golongan_id);
        $templateProcessor->setValue('jabatan', $nip->jabatan_id);
        $templateProcessor->setValue('tujuan', $notadinas->tujuan);
        $templateProcessor->setValue('jumlah_hari', 2);
        $templateProcessor->setValue('tanggal_dari', $notadinas->tanggal_dari);
        $templateProcessor->setValue('tanggal_sampai', $notadinas->tanggal_sampai);
        $templateProcessor->setValue('anggaran', $notadinas->anggaran);
        $templateProcessor->setValue('disposisi1', $notadinas->disposisi1);
        $templateProcessor->setValue('disposisi2', $notadinas->disposisi2);
        $templateProcessor->setValue('jabatan_dari', $dari->jabatan_id);
        $templateProcessor->setValue('nama_pegawai_dari', $dari->pegawai_nama);
        $templateProcessor->setValue('golongan_dari', $dari->golongan_id);
        $templateProcessor->setValue('nip_dari', $dari->pegawai_nip);

        $filename =  "notadinas " . $notadinas->id;
        $templateProcessor->saveAs($filename .  '.docx');


        // return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);

        return response()->download($filename . '.docx');


    }





}

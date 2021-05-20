<?php

namespace App\Http\Controllers\SuperAdmin\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\Dasar;
use App\Model\DasarNota;
use App\Model\Master\Golongan;
use App\Model\Master\Jabatan;
use App\Model\NotaDinas;
use App\Model\PegawaiBerangkat;
use App\Model\SuratKeluar;
use App\Pegawai;
use App\SKPD;
use Illuminate\Support\Carbon;
use JsValidator;
use PhpOffice\PhpWord\TemplateProcessor;

class NotaDinasSuperAdminController extends Controller
{
    public function index()
    {
        $jenissurat = JenisSurat::all();
        return view('super_admin.master.notadinas.notadinas_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'jenissurat' => $jenissurat,
        ]);
    }

    public function trash()
    {
        $jenissurat = JenisSurat::all();
        return view('super_admin.master.notadinas.notadinas_trashed',[
            'jenissurat' => $jenissurat,
        ]);
    }



    public function datatrash()
    {
        $user = auth()->user();

        $query = NotaDinas::orderBy('created_at','desc')->where('skpd', $user->skpd_id)->onlyTrashed();



        // $query = DB::table('sppd_suratkeluar')

        // // ->orderBy('tb_skpd.skpd_nama','asc')
        // ->orderBy('sppd_suratkeluar.created_at','desc')
        // ->where('skpd', $user->skpd_id)
        // ->get();

        // dd($query);


        return DataTables::of($query)
            ->addColumn('action', function($data) {
                return '
                    <div style="color: #fff">
                        <center>


                      <a onclick="restore('.$data->id.')" class="btn btn-success btn-sm"><i class="fa fa-undo"></i> restore</a>
                      <a onclick="deleteData('.$data->id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete Permanen</a>

                        </center>

                    </div>

                ';
            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }

    public function data()
    {
        // $query = NotaDinas::orderBy('created_at','DESC')->get();

        $user = auth()->user();

        $query = DB::table('sppd_notadinas')
        ->leftJoin('sppd_jenissurat','sppd_notadinas.jenis_surat','=','sppd_jenissurat.jenissurat_id')
        ->leftJoin('tb_jabatan','sppd_notadinas.kepada','=','tb_jabatan.jabatan_id')
        ->leftJoin('tb_pegawai','sppd_notadinas.penandatangan','=','tb_pegawai.pegawai_id')
        ->leftJoin('tb_skpd','sppd_notadinas.skpd','=','tb_skpd.skpd_id')
        // ->orderBy('tb_skpd.skpd_nama','asc')
        ->orderBy('sppd_notadinas.created_at','desc')

        ->get();
        // dd($query);

        return DataTables::of($query)

            ->addColumn('action', function($data) {
                if($data->nomor){

                return '
                    <div style="color: #fff">
                        <center>

                        <a href="' .route('superadminpegawaiberangkat.index',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-odnoklassniki"> PNS Berangkat</i></a>
                        <a href="' .route('superadmindasarnotadinas.index',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-book"> Dasar Surat</i></a>
                            <a href="' .route('superadminnotadinas.cetak',$data->id). '" class="btn btn-sm btn-warning"><i class="fa fa-print"> cetak</i></a>
                            <a onclick="editForm2('.$data->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"> Edit</i></a>


                        </center>

                    </div>

                ';

                }else{
                    return '
                    <div style="color: #fff">
                        <center>


                        <a href="' .route('superadminpegawaiberangkat.index',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-odnoklassniki"> PNS Berangkat</i></a>
                        <a href="' .route('superadmindasarnotadinas.index',$data->id). '" class="btn btn-primary btn-sm"><i class="fa fa-book"> Dasar Surat</i></a>



                            <a onclick="setujui('.$data->id.')" class="btn btn-sm btn-success"><i class="fa fa-hand-pointer-o"> Daftarkan</i></a>

                            <a href="' .route('superadminnotadinas.cetak',$data->id). '" class="btn btn-sm btn-warning"><i class="fa fa-print"> cetak</i></a>

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
            'notadinas_skpd' =>'required',

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
            'notadinas_skpd.required' =>'SKPD Harus Diisi',



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

    public function apiskpd(Request $request)
    {
        $data = [];

        if($request->has('q')){
            $search = $request->q;
            $data = DB::table("tb_skpd")

                    ->select('skpd_id','skpd_nama')
            		->where('skpd_nama','LIKE',"%$search%")
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
            $db->skpd = $request['notadinas_skpd'];
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
            ->leftJoin('tb_skpd AS E', 'E.skpd_id' ,'=', 'sppd_notadinas.skpd')

            ->select('A.jabatan_nama as jabatan_kepada', 'B.jabatan_nama as jabatan_disposisi1', 'C.jabatan_nama as jabatan_disposisi2','D.jabatan_nama as jabatan_dari', 'id', 'kepada', 'tanggal_surat', 'jenis_surat'
            ,'format_nomor','lampiran','hal','isi','tujuan','tanggal_dari','tanggal_sampai','anggaran', 'skpd_nama')

            // ->leftJoin('tb_jabatan AS B','sppd_notadinas.disposisi1','=','B.jabatan_id')
            // ->leftJoin('tb_jabatan AS C','sppd_notadinas.disposisi2','=','C.jabatan_id')


        // ->orderBy('tb_skpd.skpd_nama','asc')
            // ->orderBy('sppd_notadinas.created_at','desc')
            ->where('id', $id)
            ->first();

        // dd($db);
        echo json_encode($db);
    }

    public function edit2($id)
    {
        $db = DB::table('sppd_notadinas')

            ->leftJoin('tb_jabatan AS A','A.jabatan_id','=','sppd_notadinas.kepada')
            ->leftJoin('tb_jabatan AS B','B.jabatan_id','=','sppd_notadinas.disposisi1')
            ->leftJoin('tb_jabatan AS C','C.jabatan_id','=','sppd_notadinas.disposisi2')
            ->leftJoin('tb_jabatan AS D','D.jabatan_id','=','sppd_notadinas.penandatangan')
            ->leftJoin('tb_skpd AS E', 'E.skpd_id' ,'=', 'sppd_notadinas.skpd')

            ->select('A.jabatan_nama as jabatan_kepada', 'B.jabatan_nama as jabatan_disposisi1', 'C.jabatan_nama as jabatan_disposisi2','D.jabatan_nama as jabatan_dari', 'id', 'kepada', 'tanggal_surat', 'jenis_surat'
            ,'format_nomor','lampiran','hal','isi','tujuan','tanggal_dari','tanggal_sampai','anggaran', 'skpd_nama')

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

            $db->tahun = $date;

            if (!empty($request['notadinas_dari'])) {
                $db->penandatangan = $request['notadinas_dari'];
            }

            if (!empty($request['notadinas_kepada'])) {
                $db->kepada = $request['notadinas_kepada'];

            }

            if (!empty($request['notadinas_skpd'])) {
                $db->skpd = $request['notadinas_skpd'];

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

    public function update2(Request $request, $id)
    {
        $user = auth()->user();
        $date = Carbon::now()->format('Y');

            $db = NotaDinas::find($id);

            // dd($db);

            $suratkeluar = SuratKeluar::where('id_notadinas',$db->id)->first();
            // dd($suratkeluar);




            $db->tanggal_surat = $request['notadinas_tanggal_edit2'];
            $db->jenis_surat = $request['notadinas_jenissurat_edit2'];
            $db->format_nomor = $request['notadinas_format_edit2'];
            $db->lampiran = $request['notadinas_lampiran_edit2'];
            $db->hal = $request['notadinas_hal_edit2'];
            $db->isi = $request['notadinas_isi_edit2'];
            $db->tujuan = $request['notadinas_tujuan_edit2'];
            $db->tanggal_dari = $request['notadinas_tanggaldari_edit2'];
            $db->tanggal_sampai = $request['notadinas_tanggalsampai_edit2'];
            $db->anggaran = $request['notadinas_anggaran_edit2'];
            $db->pembuat = $user->pegawai_id;

            $db->tahun = $date;

            if (!empty($request['notadinas_dari_edit2'])) {
                $db->penandatangan = $request['notadinas_dari_edit2'];
            }

            if (!empty($request['notadinas_kepada_edit2'])) {
                $db->kepada = $request['notadinas_kepada_edit2'];

                $pejabat = Jabatan::where('jabatan_id', $request['notadinas_kepada_edit2'])->first();

                $suratkeluar->kepada = $pejabat->jabatan_nama;
            }

            // if (!empty($request['notadinas_skpd'])) {
            //     $db->skpd = $request['notadinas_skpd'];

            // }

            if (!empty($request['notadinas_disposisi1_edit2'])) {
                $db->disposisi1 = $request['notadinas_disposisi1_edit2'];


            }

            if (!empty($request['notadinas_disposisi2_edit2'])) {
                $db->disposisi2 = $request['notadinas_disposisi2_edit2'];
            }

            //untuk update surat keluar dari nota dinas ini
            $suratkeluar->tanggal = $request['notadinas_tanggal_edit2'];
            $suratkeluar->jenis_surat = $request['notadinas_jenissurat_edit2'];

            $kodesurat = JenisSurat::where('jenissurat_id', $request['notadinas_jenissurat_edit2'])->first();
            // dd($kodesurat);


            $suratkeluar->perihal = "Nota Dinas Untuk " . $request['notadinas_hal_edit2'];
            $suratkeluar->format_nomor = $request['notadinas_format_edit2'];
            $suratkeluar->nomor_lengkap = $kodesurat->kode_surat . $suratkeluar->nomor . $request['notadinas_format_edit2'];

            $suratkeluar->update();


            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }

    public function destroy($id)
    {
        $cek = NotaDinas::where('id',$id)->first();
        // dd($cek);

        $cek->delete();

        session()->flash('success', 'Data Berhasil Dihapus.');
        return redirect()->route('superadmin.notadinas.index');
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
            $db = new SuratKeluar();
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

    public function show($id){

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

        $pegawaiberangkat = PegawaiBerangkat::where('id_notadinas',$id)->get();
        $countpegawaiberangkat = count($pegawaiberangkat);


        $dasarnota = DasarNota::where('id_notadinas',$id)->get();
        $countdasarnota = count($dasarnota);
        // dd($pegawaiberangkat);

        $jenissurat = JenisSurat::where('jenissurat_id',$notadinas->jenis_surat)->first();

        // $kodesurat = Dasar::findOrFail($jenissurat);

        if($countpegawaiberangkat == 0){
            return redirect()->back()->with('alert', 'Tidak ada Pegawai Berangkat');
        }

        if($countdasarnota == 0){
            return redirect()->back()->with('alert', 'Tidak ada Dasar Surat');
        }

        if($countpegawaiberangkat > 1){
            //data pegawai yang berangkat

        // dd($datapegawai);


        // Pegawai::where('pegawai_id',$pegawaiberangkat->id_pegawai)->first();


        //dd($id);




        //tanggal
        $tanggal = tanggal_indonesia_huruf($notadinas->tanggal_surat);

        $tanggaldari = tanggal_indonesia_huruf($notadinas->tanggal_dari);
        $tanggaldari = substr($tanggaldari, 0 , -4);

        $tanggalsampai = tanggal_indonesia_huruf($notadinas->tanggal_sampai);
        // $tanggalsampai = substr($tanggalsampai, 0 , -4);


        //penandatangan
        $penandatangan = Pegawai::findOrFail($notadinas->penandatangan);
        $golonganpenandatangan = Golongan::findOrFail($penandatangan->golongan_id);
        $jabatanpenandatangan = Jabatan::findOrFail($penandatangan->jabatan_id);
        $skpdpenandatangan = SKPD::findOrFail($penandatangan->skpd_id);

        // dd($golonganpenandatangan);




        //days
        $startTimeStamp = strtotime($notadinas->tanggal_dari);
        $endTimeStamp = strtotime($notadinas->tanggal_sampai);

        $timeDiff = abs($endTimeStamp - $startTimeStamp);

        $numberDays = $timeDiff/86400+1;  // 86400 seconds in one day

        // convert to integer
        $numberDays = intval($numberDays);

        $numberterbilang = terbilang($numberDays);


        //disposisi
        $disposisi1 = Jabatan::findOrFail($notadinas->disposisi1);




        $namaskpd = $skpdpenandatangan->skpd_singkatan;

        //template
        $templateProcessor = new TemplateProcessor('template/' . $namaskpd. '_jamak.docx');
        $templateProcessor->setValue('kepada', $kepada->jabatan_nama);

        if(str_contains($dari->jabatan_nama, 'Kepala Badan') OR str_contains($dari->jabatan_nama, 'Kepala Dinas') OR
        str_contains($dari->jabatan_nama, 'Sekretaris')){
            $templateProcessor->setValue('dari', $dari->jabatan_nama . " Kabupaten Tabalong");
        }else{
            $templateProcessor->setValue('dari', $dari->jabatan_nama);
        }

        $templateProcessor->setValue('dari', $dari->jabatan_nama);
        $templateProcessor->setValue('tanggal', $tanggal);
        $templateProcessor->setValue('jenis_surat', $jenissurat->kode_surat);
        $templateProcessor->setValue('nomor', $notadinas->nomor);
        $templateProcessor->setValue('format_nomor', $notadinas->format_nomor);
        $templateProcessor->setValue('lampiran', $notadinas->lampiran);
        $templateProcessor->setValue('perihal', $notadinas->Hal);

        // dd($dasarnota);

        $templateProcessor->cloneRow('dasar_surat', $countdasarnota);
        foreach ($dasarnota as $key => $list){

            $i = $key + 1;
            // dd($key);
            $templateProcessor->setValue("no#$i", $i);
            // dd($list->id_dasar);
            $dasar = Dasar::find($list->id_dasar);
            $templateProcessor->setValue("dasar_surat#$i", $dasar->peraturan);
            $templateProcessor->setValue("tentang#$i", $dasar->tentang);
        }

        $templateProcessor->setValue('isi', $notadinas->isi);

        $templateProcessor->cloneRow('nama', $countpegawaiberangkat);
        // dd($pegawaiberangkat);
        foreach ($pegawaiberangkat as $keypegawai => $listpegawai){
            $i = $keypegawai + 1;
            $templateProcessor->setValue("no1#$i", $i);

            $peg = Pegawai::find($listpegawai->id_pegawai);
            // dd($listpegawai);
            $golpeg = Golongan::find($peg->golongan_id);
            $jabpeg = Jabatan::find($peg->jabatan_id);

            $templateProcessor->setValue("nama#$i", namaGelar($peg));
            $templateProcessor->setValue("nip_peg#$i",  konversi_nip($peg->pegawai_nip));
            $templateProcessor->setValue("gol#$i", $golpeg->golongan_nama);
            $templateProcessor->setValue("kode#$i", $golpeg->golongan_kode);
            $templateProcessor->setValue("jab#$i", $jabpeg->jabatan_nama);

        }



        $templateProcessor->setValue('tujuan', $notadinas->tujuan);
        $templateProcessor->setValue('jumlah_hari', $numberDays);
        $templateProcessor->setValue('jumlah_huruf', $numberterbilang);
        $templateProcessor->setValue('tanggal_dari', $tanggaldari);
        $templateProcessor->setValue('tanggal_sampai', $tanggalsampai);
        $templateProcessor->setValue('anggaran', $notadinas->anggaran);


        if($notadinas->disposisi2 == null){
            $templateProcessor->setValue('disposisi2', null);
        }else{
            $disposisi2 = Jabatan::find($notadinas->disposisi2);
            $templateProcessor->setValue('disposisi2', $disposisi2->jabatan_nama);

        }
        $templateProcessor->setValue('disposisi1', $disposisi1->jabatan_nama);

        if(str_contains($jabatanpenandatangan->jabatan_nama, 'Kepala Badan') OR str_contains($jabatanpenandatangan->jabatan_nama, 'Kepala Dinas') OR
        str_contains($jabatanpenandatangan->jabatan_nama, 'Sekretaris')){
            $templateProcessor->setValue('jabatan_dari', $jabatanpenandatangan->jabatan_nama . " Kabupaten Tabalong");
        }else{
            $templateProcessor->setValue('jabatan_dari', $jabatanpenandatangan->jabatan_nama);
        }

        $templateProcessor->setValue('nama_pegawai_dari', namaGelar($penandatangan));
        $templateProcessor->setValue('golongan_dari', $golonganpenandatangan->golongan_nama );
        $templateProcessor->setValue('nip_dari', konversi_nip($penandatangan->pegawai_nip));

        $filename =  "notadinas " . $notadinas->id;
        $templateProcessor->saveAs($filename .  '.docx');


        // return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);

        return response()->download($filename . '.docx');
        }else{
            //data pegawai yang berangkat
        $pegawaiberangkat1 = PegawaiBerangkat::where('id_notadinas',$id)->first();

        $datapegawai = Pegawai::where('pegawai_id',$pegawaiberangkat1->id_pegawai)->first();



        // $nip = Pegawai::findOrFail($pegawaiberangkat1->id_pegawai);

        // dd($nip);

        $golongan = Golongan::findOrFail($datapegawai->golongan_id);

        $jabatan = Jabatan::findOrFail($datapegawai->jabatan_id);

        // dd($nip);

        //tanggal
        $tanggal = tanggal_indonesia_huruf($notadinas->tanggal_surat);

        $tanggaldari = tanggal_indonesia_huruf($notadinas->tanggal_dari);
        $tanggaldari = substr($tanggaldari, 0 , -4);

        $tanggalsampai = tanggal_indonesia_huruf($notadinas->tanggal_sampai);
        // $tanggalsampai = substr($tanggalsampai, 0 , -4);

        //penandatangan
        $penandatangan = Pegawai::findOrFail($notadinas->penandatangan);
        $golonganpenandatangan = Golongan::findOrFail($penandatangan->golongan_id);
        $jabatanpenandatangan = Jabatan::findOrFail($penandatangan->jabatan_id);
        $skpdpenandatangan = SKPD::findOrFail($penandatangan->skpd_id);

        // dd($golonganpenandatangan);



        //days
        $startTimeStamp = strtotime($notadinas->tanggal_dari);
        $endTimeStamp = strtotime($notadinas->tanggal_sampai);

        $timeDiff = abs($endTimeStamp - $startTimeStamp);

        $numberDays = $timeDiff/86400+1;  // 86400 seconds in one day

        // convert to integer
        $numberDays = intval($numberDays);

        $numberterbilang = terbilang($numberDays);

        //disposisi
        $disposisi1 = Jabatan::findOrFail($notadinas->disposisi1);



        $namaskpd = $skpdpenandatangan->skpd_singkatan;
        // dd($penandatangan);

        //template
        $templateProcessor = new TemplateProcessor('template/' . $namaskpd. '_single.docx');
        $templateProcessor->setValue('kepada', $kepada->jabatan_nama);

        if(str_contains($dari->jabatan_nama, 'Kepala Badan') OR str_contains($dari->jabatan_nama, 'Kepala Dinas') OR
        str_contains($dari->jabatan_nama, 'Sekretaris')){
            $templateProcessor->setValue('dari', $dari->jabatan_nama . " Kabupaten Tabalong");
        }else{
            $templateProcessor->setValue('dari', $dari->jabatan_nama);
        }

        $templateProcessor->setValue('dari', $dari->jabatan_nama);
        $templateProcessor->setValue('tanggal', $tanggal);
        $templateProcessor->setValue('jenis_surat', $jenissurat->kode_surat);
        $templateProcessor->setValue('nomor', $notadinas->nomor);
        $templateProcessor->setValue('format_nomor', $notadinas->format_nomor);
        $templateProcessor->setValue('lampiran', $notadinas->lampiran);
        $templateProcessor->setValue('perihal', $notadinas->Hal);

        // dd($dasarnota);

        $templateProcessor->cloneRow('dasar_surat', $countdasarnota);
        foreach ($dasarnota as $key => $list){

            $i = $key + 1;
            // dd($key);
            $templateProcessor->setValue("no#$i", $i);
            // dd($list->id_dasar);
            $dasar = Dasar::find($list->id_dasar);
            $templateProcessor->setValue("dasar_surat#$i", $dasar->peraturan);
            $templateProcessor->setValue("tentang#$i", $dasar->tentang);
        }

        $templateProcessor->setValue('isi', $notadinas->isi);
        $templateProcessor->setValue('nama_pegawai', namaGelar($datapegawai));
        $templateProcessor->setValue('nip',  konversi_nip($datapegawai->pegawai_nip));
        $templateProcessor->setValue('golongan_nama', $golongan->golongan_nama);
        $templateProcessor->setValue('golongan_kode', $golongan->golongan_kode);
        $templateProcessor->setValue('jabatan', $jabatan->jabatan_nama);
        $templateProcessor->setValue('tujuan', $notadinas->tujuan);
        $templateProcessor->setValue('jumlah_hari', $numberDays);
        $templateProcessor->setValue('jumlah_huruf', $numberterbilang);
        $templateProcessor->setValue('tanggal_dari', $tanggaldari);
        $templateProcessor->setValue('tanggal_sampai', $tanggalsampai);
        $templateProcessor->setValue('anggaran', $notadinas->anggaran);

        if($notadinas->disposisi2 == null){
            $templateProcessor->setValue('disposisi2', null);
        }else{
            $disposisi2 = Jabatan::find($notadinas->disposisi2);
            $templateProcessor->setValue('disposisi2', $disposisi2->jabatan_nama);

        }
        $templateProcessor->setValue('disposisi1', $disposisi1->jabatan_nama);

        if(str_contains($jabatanpenandatangan->jabatan_nama, 'Kepala Badan') OR str_contains($jabatanpenandatangan->jabatan_nama, 'Kepala Dinas') OR
        str_contains($jabatanpenandatangan->jabatan_nama, 'Sekretaris')){
            $templateProcessor->setValue('jabatan_dari', $jabatanpenandatangan->jabatan_nama . " Kabupaten Tabalong");
        }else{
            $templateProcessor->setValue('jabatan_dari', $jabatanpenandatangan->jabatan_nama);
        }

        $templateProcessor->setValue('nama_pegawai_dari', namaGelar($penandatangan));
        $templateProcessor->setValue('golongan_dari', $golonganpenandatangan->golongan_nama );
        $templateProcessor->setValue('nip_dari', konversi_nip($penandatangan->pegawai_nip));

        $filename =  "notadinas " . $notadinas->id;
        $templateProcessor->saveAs($filename .  '.docx');

        // return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);

        return response()->download($filename . '.docx');

        }
    }


}

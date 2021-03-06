<?php

namespace App\Http\Controllers\AdminSKPD\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Master\JenisSurat;
use DB;
use Yajra\Datatables\DataTables;
use Alert;
use App\Model\DasarNota;
use App\Model\NotaDinas;
use App\Model\PegawaiBerangkat;
use App\Model\SuratKeluar;
use App\SKPD;
use Illuminate\Support\Carbon;
use JsValidator;
use PhpOffice\PhpWord\TemplateProcessor;

class SuratKeluarAdminSKPDController extends Controller
{
    public function index()
    {
        $month =  Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $jenissurat = JenisSurat::all();
        return view('admin_skpd.master.suratkeluar.suratkeluar_index', [
            'JsValidator' => JsValidator::make($this->rulesCreate(), $this->messages()),
            'JsValidatorcetak' => JsValidator::make($this->rulesCetak(), $this->messagesCetak()),
            'jenissurat' => $jenissurat,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function trash()
    {
        $jenissurat = JenisSurat::all();
        return view('admin_skpd.master.suratkeluar.suratkeluar_trashed',[
            'jenissurat' => $jenissurat,
        ]);
    }

    public function data()
    {
        $user = auth()->user();
        $year = Carbon::now()->format('Y');

        $query = SuratKeluar::orderBy('created_at','desc')->where('skpd', $user->skpd_id)->where('tahun', $year);



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



                        <a onclick="deleteData('.$data->id.')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>

                        </center>

                    </div>

                ';
                // untuk edit, pindah ke return untuk aktivasi
                //<a onclick="editForm('.$data->id.')" class="btn btn-primary btn-sm"><i class="fa fa-pencil"> Edit</i></a>
            })
            ->addIndexColumn('DT_RowIndex')
            ->toJson();
    }




    //trashed data
    public function datatrash()
    {
        $user = auth()->user();

        $query = SuratKeluar::orderBy('created_at','desc')->where('skpd', $user->skpd_id)->onlyTrashed();



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



    public function rulesCreate()
    {
        $rules = [
            'suratkeluar_kepada' => 'required',
            'suratkeluar_tanggal' =>'required',
            'suratkeluar_jenissurat' => 'required',
            'suratkeluar_format' => 'required',
            'suratkeluar_hal' => 'required',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'suratkeluar_kepada.required' => 'Tujuan Surat Wajib Diisi.',
            'suratkeluar_tanggal.required' =>'Tanggal surat wajib diisi',
            'suratkeluar_jenissurat.required' =>'Jenis surat wajib diisi',
            'suratkeluar_format.required' =>'Format nomor surat wajib diisi',
            'suratkeluar_hal.required' =>'Hal wajib diisi',
        ];
    }

    public function rulesCetak()
    {
        $rules = [
            'tahun' => 'required',

        ];

        return $rules;
    }

    public function messagesCetak()
    {
        return [
            'tahun.required' => 'Tahun Wajib Diisi.',

        ];
    }

    public function store(Request $request)
    {
        $year = Carbon::now()->format('Y');
        $user = auth()->user();
        $month =  Carbon::now()->format('m');

        $cek = DB::table('sppd_suratkeluar')
            ->where('tahun', '=', $year)
            ->where('skpd', '=', $user->skpd_id)
            ->latest()
            ->first();

        $jenissurat = $request['suratkeluar_jenissurat'];

        $kodesurat = JenisSurat::where('jenissurat_id',$jenissurat)->first();

        $format_nomor = "/".$request['suratkeluar_format']."/".$month."/".$year;

        // $tanggal = date("d-m-Y", strtotime($request['suratkeluar_tanggal']))



        if($cek == null){
            $db = new SuratKeluar;
            $db->nomor = 1;
            $db->nomor_lengkap = $kodesurat->kode_surat . 1 . $format_nomor;
            $db->jenis_surat = $kodesurat->jenissurat_id;
            $db->format_nomor = $format_nomor;
            $db->kepada = $request['suratkeluar_kepada'];
            $db->tanggal = $request['suratkeluar_tanggal'];
            $db->perihal = $request['suratkeluar_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;

            $db->save();

            return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);
        }else{
            $db = new SuratKeluar;
            $db->nomor = $cek->nomor+1;
            $cek1 = $cek->nomor+1;
            $db->jenis_surat = $kodesurat->jenissurat_id;
            $db->format_nomor = $format_nomor;
            $db->nomor_lengkap = $kodesurat->kode_surat . $cek1 . $format_nomor;
            $db->kepada = $request['suratkeluar_kepada'];
            $db->tanggal = $request['suratkeluar_tanggal'];
            $db->perihal = $request['suratkeluar_hal'];
            $db->tahun = $year;
            $db->skpd = $user->skpd_id;

            $db->save();

            return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);
        }

    }

    public function edit($id)
    {
        $db = DB::table('sppd_suratkeluar')


            ->where('id', $id)
            ->first();

        // dd($db);
        echo json_encode($db);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $year = Carbon::now()->format('Y');

        $db = SuratKeluar::find($id);

        $jenissurat = $request['suratkeluar_jenissurat'];

        $kodesurat = JenisSurat::where('jenissurat_id',$jenissurat)->first();

        $format_nomor = $request['suratkeluar_format'];


        $db->jenis_surat = $jenissurat;
        $db->format_nomor = $format_nomor;
        $db->nomor_lengkap = $kodesurat->kode_surat . $db->nomor . $format_nomor;
        $db->kepada = $request['suratkeluar_kepada'];
        $db->tanggal = $request['suratkeluar_tanggal'];
        $db->perihal = $request['suratkeluar_hal'];
        $db->tahun = $year;
        $db->skpd = $user->skpd_id;


            $db->update();
            return response()->json(['code'=>200, 'status' => 'Dasar Surat Berhasil Disimpan'], 200);

    }

    public function show($id){

    }

    public function destroy($id)
    {
        $db = SuratKeluar::find($id);
        $db->delete();
    }

    public function restore($id)
    {
        //dd($id);
        // $restore = SuratKeluar::where('id', $id)->first();
        //$restore = SuratKeluar::find($id);

        $restore = DB::table('sppd_suratkeluar')
        ->where('id', $id)
        ->update(['deleted_at' => null]);

        // $restore->deleted_at = null;
        // $restore->update();

        session()->flash('success', 'Data Berhasil Dikembalikan.');
        //dd($db);
        // $db = SuratKeluar::find($id);
        // dd($id);
    	// $db->restore();
    }

    public function deletepermanen($id)
    {


        $suratkeluar = SuratKeluar::onlyTrashed('id', $id)->first();
        // dd($suratkeluar);

        if($suratkeluar->id_notadinas){
            $notadinas = NotaDinas::where('id', $suratkeluar->id_notadinas);
            // dd($notadinas);
            $notadinas->delete();

            $dasarnota = DasarNota::where('id_notadinas', $suratkeluar->id_notadinas);
            $pegawaiberangkat = PegawaiBerangkat::where('id_notadinas', $suratkeluar->id_notadinas);

            $dasarnota->delete();
            $pegawaiberangkat->delete();
        }

        $suratkeluar->forcedelete();


        // DB::table('sppd_suratkeluar')->where('id', $id)->delete();



    }

    public function cetak (Request $request){
        $tahun = $request['tahun'];
        $user = auth()->user();

        $skpd = SKPD::find($user->skpd_id)->first();
        // dd($skpd);

        $suratkeluar = SuratKeluar::where('tahun',$tahun)
                       ->where('skpd', $skpd->skpd_id)
                       ->get();

        $countsuratkeluar = count($suratkeluar);


        //dd($suratkeluar);

        $templateProcessor = new TemplateProcessor('template/buku_surat_keluar/admin_skpd.docx');
        $templateProcessor->setValue('SKPD', $skpd->skpd_nama);
        $templateProcessor->setValue('tahun', $tahun);

        $templateProcessor->cloneRow('tujuan', $countsuratkeluar);
        foreach ($suratkeluar as $key => $list){

            $i = $key + 1;
            // dd($key);
            $templateProcessor->setValue("no#$i", $i);
            // dd($list->id_dasar);
            $templateProcessor->setValue("tujuan#$i", $list->kepada);
            $templateProcessor->setValue("tanggal#$i", $list->tanggal);
            $templateProcessor->setValue("nomor_lengkap#$i", $list->nomor_lengkap);
            $templateProcessor->setValue("perihal#$i", $list->perihal);

        }

        $filename =  "surat keluar " . $skpd->nama . "Tahun" . $tahun;
        $templateProcessor->saveAs($filename .  '.docx');


        // return response()->json(['code'=>200, 'status' => 'Nota Dinas berhasil dicatat ke Buku Surat Keluar'], 200);

        return response()->download($filename . '.docx');
    }

}

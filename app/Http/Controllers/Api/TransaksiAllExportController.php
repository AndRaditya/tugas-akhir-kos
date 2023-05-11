<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Mail;
use App\Models\TransaksiKeluar as TransaksiKeluarModel;
use App\Models\TransaksiMasuk as TransaksiMasukModel;
use Carbon\Carbon;

class TransaksiAllExportController extends Controller
{
    CONST PRIMARY_KEY = 'id';
        
    private $transaksiKeluarModel;
    private $transaksiMasukModel;

    public function __construct(TransaksiKeluarModel $transaksiKeluarModel, TransaksiMasukModel $transaksiMasukModel)
    {
        $this->transaksiKeluarModel = $transaksiKeluarModel;
        $this->transaksiMasukModel = $transaksiMasukModel;
    }

    public function generatePDF(Request $request){
        $start_date = $request->tanggal_mulai;
        $end_date = $request->tanggal_selesai;

        $docs_masuk = $this->transaksiMasukModel
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->with('biaya_tambahan')
                ->get();


        $docs_keluar = $this->transaksiKeluarModel
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->get();
       
        $tanggal_mulai = Carbon::parse($start_date)->format('d-m-Y');
        $tanggal_selesai = Carbon::parse($end_date)->format('d-m-Y');

        $datas = [
            'data_masuk' => $docs_masuk,
            'data_keluar' => $docs_keluar,
            'date_mulai' => $tanggal_mulai,
            'date_selesai' => $tanggal_selesai,
        ];

        $pdf = PDF::loadView('transaksi-semua', $datas);
        $pdf->setPaper('A4', 'landscape');
        // return $pdf->output();
        return $pdf->download('Document.pdf');   //untuk download pdf
        // return $pdf->stream('Document.pdf');    //untuk preview pdf
        
    }
}
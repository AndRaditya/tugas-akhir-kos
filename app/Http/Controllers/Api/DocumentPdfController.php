<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PDF;
use DB;
use Mail;
use App\Models\TransaksiMasuk as TransaksiMasukModel;
use Carbon\Carbon;

class DocumentPdfController extends Controller
{
    CONST PRIMARY_KEY = 'id';
        
    private $transaksiMasukModel;

    public function __construct(TransaksiMasukModel $transaksiMasukModel)
    {
        $this->transaksiMasukModel = $transaksiMasukModel;
    }

    public function generatePDF(){

        $start_date = '2023-05-01';
        $end_date = '2023-05-05';

        $docs = $this->transaksiMasukModel
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->with('biaya_tambahan')
                ->get();
       
        $tanggal_mulai = Carbon::parse($start_date)->format('d-m-Y');
        $tanggal_selesai = Carbon::parse($end_date)->format('d-m-Y');

        $datas = [
            'data' => $docs,
            'date_mulai' => $tanggal_mulai,
            'date_selesai' => $tanggal_selesai,
        ];

        $pdf = PDF::loadView('transaksi-masuk', $datas);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Document.pdf');   //untuk download pdf
        // return $pdf->stream('Document.pdf');    //untuk preview pdf
    }
}
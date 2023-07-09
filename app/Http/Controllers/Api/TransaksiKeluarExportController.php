<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use DB;
use Mail;
use App\Models\TransaksiKeluar as TransaksiKeluarModel;
use Carbon\Carbon;

class TransaksiKeluarExportController extends Controller
{
    CONST PRIMARY_KEY = 'id';
        
    private $transaksiKeluarModel;

    public function __construct(TransaksiKeluarModel $transaksiKeluarModel)
    {
        $this->transaksiKeluarModel = $transaksiKeluarModel;
    }

    public function generatePDF(Request $request){
        $start_date = $request->tanggal_mulai;
        $end_date = $request->tanggal_selesai;

        $docs = $this->transaksiKeluarModel
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->get();

        foreach($docs as $doc){
            $total_harga = $doc->sum('nilai');
        }         
       
        $tanggal_mulai = Carbon::parse($start_date)->format('d-m-Y');
        $tanggal_selesai = Carbon::parse($end_date)->format('d-m-Y');

        $datas = [
            'data' => $docs,
            'date_mulai' => $tanggal_mulai,
            'date_selesai' => $tanggal_selesai,
            'total_harga' => $total_harga,
        ];

        $pdf = PDF::loadView('transaksi-keluar', $datas);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Document.pdf');   //untuk download pdf
    }
}
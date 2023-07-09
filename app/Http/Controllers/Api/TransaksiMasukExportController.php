<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use DB;
use Mail;
use App\Models\TransaksiMasuk as TransaksiMasukModel;
use Carbon\Carbon;
use App;

class TransaksiMasukExportController extends Controller
{
    // CONST PRIMARY_KEY = 'id';
        
    private $transaksiMasukModel;

    public function __construct(TransaksiMasukModel $transaksiMasukModel)
    {
        $this->transaksiMasukModel = $transaksiMasukModel;
    }

    public function generatePDF(Request $request){
        return DB::transaction(function () use ($request) {
            $start_date = $request['tanggal_mulai'];
            $end_date = $request['tanggal_selesai'];

            $docs = $this->transaksiMasukModel
            ->whereDate('tanggal', '>=', $start_date)
            ->whereDate('tanggal', '<=', $end_date)
            ->with('biaya_tambahan')
            ->get();

            $total_harga = 0;

            foreach($docs as $doc){
                if($doc['total_nilai']){
                    $total_harga += $doc['total_nilai'];
                }
            }

            $tanggal_mulai = Carbon::parse($start_date)->format('d-m-Y');
            $tanggal_selesai = Carbon::parse($end_date)->format('d-m-Y');
            
            $datas = [
                'data' => $docs,
                'date_mulai' => $tanggal_mulai,
                'date_selesai' => $tanggal_selesai,
                'total_harga' => $total_harga
            ];
            
            $pdf = PDF::loadView('transaksi-masuk', $datas);
            $pdf->setPaper('A4', 'landscape');
            return $pdf->download('Document.pdf');  
        });
    }
}
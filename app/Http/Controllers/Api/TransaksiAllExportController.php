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

        foreach($docs_masuk as $doc){
            $total_harga_masuk = $doc->sum('total_nilai');
        }


        $docs_keluar = $this->transaksiKeluarModel
                ->whereBetween('tanggal', [$start_date, $end_date])
                ->get();

        foreach($docs_keluar as $doc){
            $total_harga_keluar = $doc->sum('nilai');
        }
       
        $tanggal_mulai = Carbon::parse($start_date)->format('d-m-Y');
        $tanggal_selesai = Carbon::parse($end_date)->format('d-m-Y');

        $datas = [
            'data_masuk' => $docs_masuk,
            'data_keluar' => $docs_keluar,
            'date_mulai' => $tanggal_mulai,
            'date_selesai' => $tanggal_selesai,
            'total_harga_masuk' => $total_harga_masuk,
            'total_harga_keluar' => $total_harga_keluar,
        ];

        $pdf = PDF::loadView('transaksi-semua', $datas);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Document.pdf');   //untuk download pdf
    }

    public function generateLaporanPDF(Request $request){
        $start_date = $request->tanggal_mulai;
        $end_date = $request->tanggal_selesai;

		$docs_masuk = $this->transaksiMasukModel
						->whereDate('tanggal', '>=', $start_date)
						->whereDate('tanggal', '<=', $end_date)
                        ->with('biaya_tambahan')
						->get()
						->groupBy(function($item){
							return $item->tanggal->format('Y-m-d');
						});
                        
		$total_nilai_trs_masuk = [];
		$nilai_trs_masuk = [];
        $biaya_tambahan = [];
        $tanggal_trs_masuk = [];
        $i = 0;
        $merged_trs_masuk = [];
        $total_transaksi_masuk = [];
        $total_harga_masuk = 0;

		foreach($docs_masuk as $docs){
			$total_nilai_trs_masuk_temp = 0;
			$nilai_trs_masuk_temp = 0;
            $biaya_tambahan_temp = 0;
            $total_transaksi_masuk_temp = 0;
            $date = $docs[0]['tanggal']->format('Y-m-d');
            
            array_push($tanggal_trs_masuk, $date);

			foreach($docs as $doc){
				$total_nilai_trs_masuk_temp += $doc['total_nilai'];
				$nilai_trs_masuk_temp += $doc['nilai'];
                $total_transaksi_masuk_temp+=1;
                if(count($doc['biaya_tambahan']) > 0){
                    $biaya = $doc['biaya_tambahan'][0]['nilai'];
                    $biaya_tambahan_temp += $biaya;
                }
			}
            array_push($biaya_tambahan, $biaya_tambahan_temp);
			array_push($total_nilai_trs_masuk, $total_nilai_trs_masuk_temp);
			array_push($nilai_trs_masuk, $nilai_trs_masuk_temp);
			array_push($total_transaksi_masuk, $total_transaksi_masuk_temp);
        }

        foreach($total_nilai_trs_masuk as $each_total_nilai){
            $data_trs_masuk = [
                'tanggal' => $tanggal_trs_masuk[$i],
                'total_transaksi' => $total_transaksi_masuk[$i],
                'nilai' => $nilai_trs_masuk[$i],
                'biaya_tambahan' => $biaya_tambahan[$i], 
                'total_nilai' => $total_nilai_trs_masuk[$i],
            ];
            $i++;
            array_push($merged_trs_masuk, $data_trs_masuk);
        }

        foreach($merged_trs_masuk as $trs_masuk){
            $total_harga_masuk += $trs_masuk['total_nilai'];
        }

        $docs_keluar = $this->transaksiKeluarModel
                        ->whereDate('tanggal', '>=', $start_date)
                        ->whereDate('tanggal', '<=', $end_date)
                        ->get()
                        ->groupBy(function($item_trs){
                            return $item_trs->tanggal->format('Y-m-d');
                        });

        $nilai_trs_keluar = [];
        $tanggal_trs_keluar = [];
        $i = 0;
        $merged_trs_keluar = [];
        $total_transaksi_keluar = [];
        $total_harga_keluar = 0;

        foreach($docs_keluar as $docs){
            $nilai_trs_keluar_temp = 0;
            $total_transaksi_keluar_temp = 0;
            $date = $docs[0]['tanggal']->format('Y-m-d');
            
            array_push($tanggal_trs_keluar, $date);

            foreach($docs as $doc){
                $nilai_trs_keluar_temp += $doc['nilai'];
                $total_transaksi_keluar_temp+=1;
            }
            array_push($total_transaksi_keluar, $total_transaksi_keluar_temp);
            array_push($nilai_trs_keluar, $nilai_trs_keluar_temp);
        }

        foreach($nilai_trs_keluar as $each_total_nilai){
            $data_trs_keluar = [
                'tanggal' => $tanggal_trs_keluar[$i],
                'total_transaksi' => $total_transaksi_keluar[$i],
                'nilai' => $nilai_trs_keluar[$i],
            ];
            $i++;
            array_push($merged_trs_keluar, $data_trs_keluar);
        }

        foreach($merged_trs_keluar as $trs_keluar){
            $total_harga_keluar += $trs_keluar['nilai'];
        }

        ////////////////////
        // Merge Transaksi

        $tanggal_mulai = Carbon::parse($start_date)->format('d-m-Y');
        $tanggal_selesai = Carbon::parse($end_date)->format('d-m-Y');

        $datas = [
            'data_masuk' => $merged_trs_masuk,
            'data_keluar' => $merged_trs_keluar,
            'date_mulai' => $tanggal_mulai,
            'date_selesai' => $tanggal_selesai,
            'total_harga_masuk' => $total_harga_masuk,
            'total_harga_keluar' => $total_harga_keluar,
        ];


        $pdf = PDF::loadView('transaksi-export', $datas);
        $pdf->setPaper('A4', 'landscape');
        return $pdf->download('Document.pdf');   
    }
}
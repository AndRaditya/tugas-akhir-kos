<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NumberGeneratorService;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\TransaksiKeluarKategori;
use App\Services\TransaksiKeluarService;
use DB;
use Illuminate\Support\Facades\Schema;

class TransaksiKeluarController extends Controller
{
    
    private $transaksiKeluarService;
    private $numberGeneratorService;

    public function __construct(TransaksiKeluarService $transaksiKeluarService, NumberGeneratorService $numberGeneratorService)
    {
        $this->transaksiKeluarService = $transaksiKeluarService;
        $this->numberGeneratorService = $numberGeneratorService;
    }

    public function getAll()
    {
        $result = $this->transaksiKeluarService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($id)
    {
        $result = $this->transaksiKeluarService->get($id);
        $trs_keluar_kategori_name = TransaksiKeluarKategori::where('id', $result[0]['transaksi_keluar_kategori_id'])->select('name')->first();
        
        if($trs_keluar_kategori_name){
            $result[0]['kategori_name'] = [$trs_keluar_kategori_name->name];
        }

        return ResponseHelper::get($result);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $kategori_name = $request['kategori_name'];
            $transaksi_keluar_kategori_id = TransaksiKeluarKategori::where('name', $kategori_name)->select('id')->first();

            $data = $request->only(Schema::getColumnListing('transaksi_keluars'));
            $data['no'] = $this->numberGeneratorService->generateNumber('TRSOUT');
            $data['transaksi_keluar_kategori_id'] = $transaksi_keluar_kategori_id->id;

            $kosQuery = $this->transaksiKeluarService->create($data);

            return ResponseHelper::create($kosQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $kategori_name = $request['kategori_name'];
            $transaksi_keluar_kategori_id = TransaksiKeluarKategori::where('name', $kategori_name)->select('id')->first();

            $request = $request->only(Schema::getColumnListing('transaksi_keluars'));
            $request['transaksi_keluar_kategori_id'] = $transaksi_keluar_kategori_id->id;
            $request['updated_at'] = now();

            $container = $this->transaksiKeluarService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->transaksiKeluarService->delete($id);
        return ResponseHelper::delete();
    }

    public function getChart(Request $request){
        $data_tahun = @$request->tahun;
        $data_kategori = @$request->kategori;

        $datas = $this->transaksiKeluarService->getChart($data_tahun, $data_kategori);
        $months = array_keys($datas->toArray());

        $trs_each_month = [];
        
        foreach($datas as $data){
            array_push($trs_each_month, count($data));
        }

        $merged_trs_keluar = [];

        for($i = 0; $i < count($datas); $i++){
            $data_trs_keluar = [
                'month' => $months[$i],
                'total_trs' => $trs_each_month[$i],
            ];
            array_push($merged_trs_keluar, $data_trs_keluar);
        }

        $array_dummy = [];
        
        for($i = 1; $i < 13; $i++){
            $array_dummy_trs = [
                'month' => $i,
                'total_trs' => 0,
            ];
            array_push($array_dummy, $array_dummy_trs);
        }
        
        for($i = 0; $i < count($array_dummy); $i++){
            foreach($merged_trs_keluar as $merged){
                if($merged['month'] == $array_dummy[$i]['month']){
                    $array_dummy[$i]['total_trs'] = $merged['total_trs'];
                }
            }
        }

        $trs_all_month = [];
        foreach($array_dummy as $array){
            array_push( $trs_all_month, $array['total_trs']);
        }

        return $trs_all_month;
    }
 
}
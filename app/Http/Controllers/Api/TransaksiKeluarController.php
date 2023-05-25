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
 
}
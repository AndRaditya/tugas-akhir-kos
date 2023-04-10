<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NumberGeneratorService;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
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
        return ResponseHelper::get($result);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('transaksi_keluars'));
            $data['no'] = $this->numberGeneratorService->generateNumber('TRSOUT');

            $kosQuery = $this->transaksiKeluarService->create($data);
            return ResponseHelper::create($kosQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $request = $request->only(Schema::getColumnListing('transaksi_keluars'));
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
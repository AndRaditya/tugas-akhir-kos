<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransaksiMasukService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use DB;
use Illuminate\Support\Facades\Schema;


class TransaksiMasukController extends Controller
{
    private $transaksiMasukService;
    private $numberGeneratorService;


    public function __construct(TransaksiMasukService $transaksiMasukService, NumberGeneratorService $numberGeneratorService)
    {
        $this->transaksiMasukService = $transaksiMasukService;
        $this->numberGeneratorService = $numberGeneratorService;

    }
 
    public function getAll()
    {
        $result = $this->transaksiMasukService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($id)
    {
        $result = $this->transaksiMasukService->get($id);
        return ResponseHelper::get($result);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('transaksi_masuks'));
            $data['no'] = $this->numberGeneratorService->generateNumber('TRSIN');

            $kosQuery = $this->transaksiMasukService->create($data);
            return ResponseHelper::create($kosQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $request = $request->only(Schema::getColumnListing('transaksi_masuks'));
            $request['updated_at'] = now();

            $container = $this->transaksiMasukService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->transaksiMasukService->delete($id);
        return ResponseHelper::delete();
    }

    

}
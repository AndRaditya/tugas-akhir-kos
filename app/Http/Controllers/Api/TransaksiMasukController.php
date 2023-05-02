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
    private $biayaTambahanController;


    public function __construct(TransaksiMasukService $transaksiMasukService, NumberGeneratorService $numberGeneratorService, BiayaTambahanController $biayaTambahanController)
    {
        $this->transaksiMasukService = $transaksiMasukService;
        $this->numberGeneratorService = $numberGeneratorService;
        $this->biayaTambahanController = $biayaTambahanController;
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
            
            $trsMasukQuery = $this->transaksiMasukService->create($data);

            if(!empty($request->biaya_tambahan)){
                $biaya_tambahan = $request->biaya_tambahan;
                
                $this->biayaTambahanController->create($biaya_tambahan, $trsMasukQuery);
            }

            if(!empty($request->bukti_transfer)){
                $bukti_transfer = $request->bukti_transfer;

                $this->transaksiMasukService->insertBuktiTransfer($bukti_transfer, $trsMasukQuery, $data['no']);
            }
            return ResponseHelper::create($trsMasukQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {

            if(!empty($request['bukti_transfer'])){
                $bukti_transfer = $request['bukti_transfer'];

                $this->transaksiMasukService->insertBuktiTransfer($bukti_transfer, $id, $request['no']);
            }

            $this->biayaTambahanController->deleteSelected($id);

            if($request->biaya_tambahan > 0){
                $biaya_tambahan = $request->biaya_tambahan;

                $this->biayaTambahanController->create($biaya_tambahan, $id);
            }

            $request = $request->only(Schema::getColumnListing('transaksi_masuks'));
            $request['updated_at'] = now();

            $container = $this->transaksiMasukService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function deleteBuktiTransfer($id, Request $request)
    {
        $photo = $request->bukti_transfer;
        if ($photo) {
            return $this->transaksiMasukService->deleteBuktiTransfer($id, $photo);
        }
    }

    public function delete($id)
    {
        $this->transaksiMasukService->delete($id);
        return ResponseHelper::delete();
    }

    

}
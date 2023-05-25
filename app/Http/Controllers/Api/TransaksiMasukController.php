<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransaksiMasukService;
use App\Services\NumberGeneratorService;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\KosBooking;
use App\Models\KosBuktiTransfer;
use App\Models\TransaksiMasuk;
use App\Models\TransaksiMasukKategori;
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

        $trs_masuk_kategori_name = TransaksiMasukKategori::where('id', $result[0]['transaksi_masuk_kategori_id'])->select('name')->first();
        $kode_booking = KosBooking::where('id', $result[0]['kos_booking_id'])->select('kode')->first();
        
        if($trs_masuk_kategori_name){
            $result[0]['kategori_name'] = [$trs_masuk_kategori_name->name];
        }
        if($kode_booking){
            $result[0]['nomor_booking'] = [$kode_booking->kode];
        }

        return ResponseHelper::get($result);
    }

    public function create(Request $request){
        return DB::transaction(function () use ($request){
            $kategori_name = $request['kategori_name'];
            $transaksi_masuk_kategori_id = TransaksiMasukKategori::where('name', $kategori_name)->select('id')->first();

            $kos_booking_id = KosBooking::where('kode', $request['nomor_booking'])->select('id')->first();

            $data = $request->only(Schema::getColumnListing('transaksi_masuks'));
            $data['no'] = $this->numberGeneratorService->generateNumber('TRSIN');
            $data['transaksi_masuk_kategori_id'] = $transaksi_masuk_kategori_id->id;
            $data['kos_booking_id'] = $kos_booking_id->id;
            
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

    public function createByBooking($array_data){
        return DB::transaction(function () use ($array_data){
            $kategori_name = $array_data['kategori_name'];
            $transaksi_masuk_kategori_id = TransaksiMasukKategori::where('name', $kategori_name)->select('id')->first();

            $array_data['no'] = $this->numberGeneratorService->generateNumber('TRSIN');
            $array_data['transaksi_masuk_kategori_id'] = $transaksi_masuk_kategori_id->id;
            
            $trsMasukQuery = $this->transaksiMasukService->create($array_data);

            return ResponseHelper::create($trsMasukQuery);
        });
    }

    public function duplicateBuktiTransfer($data){
        return KosBuktiTransfer::create($data)->id;
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $kategori_name = $request['kategori_name'];
            $transaksi_masuk_kategori_id = TransaksiMasukKategori::where('name', $kategori_name)->select('id')->first();
            $kos_booking_id = KosBooking::where('kode', $request['nomor_booking'])->select('id')->first();


            if(!empty($request['bukti_transfer'])){
                $bukti_transfer = $request['bukti_transfer'];
                
                if(!is_array($bukti_transfer)){
                    $this->transaksiMasukService->insertBuktiTransfer($bukti_transfer, $id, $request['no']);
                }
            }

            $this->biayaTambahanController->deleteSelected($id);

            if(!empty($request->biaya_tambahan)){
                $biaya_tambahan = $request->biaya_tambahan;

                $this->biayaTambahanController->create($biaya_tambahan, $id);
            }

            $request = $request->only(Schema::getColumnListing('transaksi_masuks'));
            $request['transaksi_masuk_kategori_id'] = $transaksi_masuk_kategori_id->id;
            $request['updated_at'] = now();
            $request['kos_booking_id'] = $kos_booking_id->id;


            $container = $this->transaksiMasukService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function updateBuktiBooking($id, $bukti){
        $data['kos_bukti_transfer_id'] = $bukti;

        return TransaksiMasuk::find($id)->update($data);
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
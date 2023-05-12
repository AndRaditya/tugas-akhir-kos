<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\KamarService;
use App\Services\KosBookingService;
use App\Services\NumberGeneratorService;
use DB;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Carbon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage; 
use App\Models\Kamar;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class KosBookingController extends Controller
{
    const DEFAULT_PER_PAGE = 25;
    private $kosBookingService;
    private $numberGeneratorService;
    private $kamarService;
    private $kamarController;

    public function __construct(KosBookingService $kosBookingService, NumberGeneratorService $numberGeneratorService, KamarService $kamarService, KamarController $kamarController)
    {
        $this->kosBookingService = $kosBookingService;
        $this->kamarService = $kamarService;
        $this->kamarController = $kamarController;
        $this->numberGeneratorService = $numberGeneratorService;
    }

    public function getAll()
    {
        $result = $this->kosBookingService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($id)
    {
        $result = $this->kosBookingService->get($id);
        return ResponseHelper::get($result);
    }

    public function getKodeBooking()
    {
        $result = $this->kosBookingService->getKodeBooking();
        
        $result->transform(function ($d) {
            return [
                'text' => $d->kode,
                'value' => $d->id,
            ];
        });

        return $result;
    }

    public function getByUser($user_id){
        $result = $this->kosBookingService->getByUser($user_id);
        return ResponseHelper::get($result);
    }

    public function getByStatusByUser($user_id){
        $result = $this->kosBookingService->getByStatusByUser($user_id);
        return ResponseHelper::get($result);
    }

    public function searchPaginate(Request $request){
        $keyword = @$request->keyword;
        $user_id = @$request->user_id;

        $data = $this->kosBookingService->searchPaginate($keyword, $user_id);
        return $data;
    }

    public function getFilter(Request $request){
        $filter = $this->extrackFilter($request);
        $user_id = @$request->user_id;

        $result = $this->kosBookingService->getFilter($filter, $user_id);

        return $result;
    }

    private function extrackFilter(Request $request)
    {
        $filter = [];
        $filter['user_name'] = @$request->user_name;
        $filter['nomor_kamar'] = @$request->nomor_kamar;
        $filter['kode'] = @$request->kode;
        $filter['date'] = @$request->date;
        $filter['tanggal_mulai'] = @$request->tanggal_mulai;
        $filter['tanggal_selesai'] = @$request->tanggal_selesai;
        $filter['status'] = @$request->status;
        $filter['total_price'] = @$request->total_price;
        $filter['total_bulan'] = @$request->total_bulan;

        return $filter;
    }

    public function getSortData(Request $request){
        $data = @$request->sort_data;
        $user_id = @$request->user_id;

        $sorted = $this->filterSort($data);

        $result = $this->kosBookingService->getSortData($sorted, $user_id);

        return $result;
    }

    public function filterSort($data){
        $filter = [];
        if($data == 'Tanggal Awal - Akhir'){
            $filter['jenis'] = 'date';
            $filter['sort'] = 'asc';
        }else if($data == 'Tanggal Akhir - Awal'){
            $filter['jenis'] = 'date';
            $filter['sort'] = 'desc';
        }else if($data == 'Harga Termurah'){
            $filter['jenis'] = 'total_price';
            $filter['sort'] = 'asc';
        }else if($data == 'Harga Tertinggi'){
            $filter['jenis'] = 'total_price';
            $filter['sort'] = 'desc';
        }else{
            $filter['jenis'] = 'status';
            $filter['sort'] = 'desc';
        }

        return $filter;
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $bukti_transfer = $request['bukti_transfer'];
            
            $data = $request->only(Schema::getColumnListing('kos_bookings'));
            $tanggal_mulai = Carbon::parse($data['tanggal_mulai']);
            $total_bulan = $data['total_bulan'];
            $total_kamar = $data['total_kamar'];
            $tanggal_selesai = $tanggal_mulai->addMonths($total_bulan);
            
            $harga_utama = 1500000;
            $total_harga = $harga_utama * $total_bulan * $total_kamar;

            $data['tanggal_selesai'] = $tanggal_selesai;
            $data['status'] = "Menunggu Konfirmasi Pengelola";
            $data['total_price'] = $total_harga;
            $data['kode'] = $this->numberGeneratorService->generateNumber('BOOK');

            $kosBookingQuery = $this->kosBookingService->create($data);

            if($bukti_transfer){
                $this->kosBookingService->insertBuktiTransfer($bukti_transfer, $kosBookingQuery, $data['kode']);
            }

            return ResponseHelper::create($kosBookingQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $nomor_kamar = $request['nomor_kamar'];
            $user_id = $request['user']['id'];
            $request = $request->only(Schema::getColumnListing('kos_bookings'));
            $request['updated_at'] = now();

            if($nomor_kamar && $request['status'] != 'Dibatalkan'){
                $data = [];
                $nama_user = User::where('id', $user_id)->select('name')->first();
                
                foreach($nomor_kamar as $nomor){
                    $data['number'] = $nomor;
                    $data['status'] = 'Dipakai';
                    $kamar_id = Kamar::where('number', $data['number'])->select('id')->first();
                    $data['id'] = $kamar_id['id'];
                    $data['nama_penyewa'] = $nama_user->name;

                    $this->kamarController->updateStatusKamar($data, $id);
                }

                $request['kamar_id'] = $kamar_id['id'];
            }
            $container = $this->kosBookingService->update($id, $request);
            return ResponseHelper::put($container);
        });
    }

    public function pembayaran($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $bukti_transfer = $request->bukti_transfer;
            $kode = $request->kode;
            
            if($bukti_transfer){
                $this->kosBookingService->insertBuktiTransfer($bukti_transfer, $id, $kode);
            }

        });
    }

    public function delete($id)
    {
        $this->kosBookingService->delete($id);
        return ResponseHelper::delete();
    }
}
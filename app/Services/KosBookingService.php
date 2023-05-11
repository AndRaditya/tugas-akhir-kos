<?php

namespace App\Services;

use App\Models\KosBuktiTransfer;
use App\Repositories\KosBookingRepository;

class KosBookingService
{
    /** @var KosBookingRepository */
    private $kosBookingRepository;
    private $fileHandlerService;


    public function __construct(KosBookingRepository $kosBookingRepository, FileHandlerService $fileHandlerService){
        $this->kosBookingRepository = $kosBookingRepository;
        $this->fileHandlerService = $fileHandlerService;

    }

    public function getAll(){
        return $this->kosBookingRepository->getAll();
    }

    public function get($id){
        return $this->kosBookingRepository->get($id);
    }

    public function getByUser($user_id){
        return $this->kosBookingRepository->getByUser($user_id);
    }

    public function getByStatusByUser($user_id){
        return $this->kosBookingRepository->getByStatusByUser($user_id);
    }

    public function searchPaginate($keyword, $user_id){
        return $this->kosBookingRepository->searchPaginate($keyword, $user_id);
    } 

    public function getFilter($filter, $user_id){

        if($user_id){
            $container = KosBooking::with(['user', 'kamar'])->where('users_id', $user_id);
        }else{
            $container = KosBooking::with(['user', 'kamar']);
        }

        $container = $this->filtering($container, $filter);
        return $container                    
                ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                ->orderBy('date', 'DESC')
                ->get();
    }

    public function filtering($container, $filter){
        if ($filter && count($filter)) {
            if ($filter['user_name']) {
                $userName = $filter['user_name'];
                $container = $container->whereHas('user', function ($q) use ($userName){
                    $q->where('name', 'like', '%' . $userName . '%');
                });
            }
            if ($filter['nomor_kamar']) {
                $nomorKamar = $filter['nomor_kamar'];
                $container = $container->whereHas('kamar', function ($q) use ($nomorKamar){
                    $q->where('number', 'like', '%' . $nomorKamar . '%');
                });
            }
            if ($filter['kode']) {
                $container = $container->where('kode', 'like', '%' .  $filter['kode'] . '%');
            }
            if ($filter['date']) {
                $date = $filter['date'];
                
                if($date['start_date'] && $date['end_date']){
                    $from = date($date['start_date']) . " 00:00:00";
                    $to = date($date['end_date']) . " 23:59:59";
                    $container = $container->whereBetween('date', [$from, $to]);
                }
            }
            if ($filter['tanggal_mulai']) {
                $container = $container->where('tanggal_mulai', 'like', '%' . $filter['tanggal_mulai'] . '%');
            }
            if ($filter['tanggal_selesai']) {
                $container = $container->where('tanggal_selesai', 'like', '%' . $filter['tanggal_selesai'] . '%');
            }
            if ($filter['status']) {
                $container = $container->where('status', 'like', '%' . $filter['status'] . '%');
            }
            if ($filter['total_price']) {
                $container = $container->where('total_price', 'like', '%' . $filter['total_price'] . '%');
            }
            if ($filter['total_bulan']) {
                $container = $container->where('total_bulan', 'like', '%' . $filter['total_bulan'] . '%');
            }
        }
        return $container;
    }

    public function getSortData($sorted, $user_id){
        return $this->kosBookingRepository->getSortData($sorted, $user_id);
    }

    public function delete($id) {
        return $this->kosBookingRepository->delete($id);
    }
    
    public function update($id, $data) {
        return $this->kosBookingRepository->update($id, $data);
    }
    
    public function insertBuktiTransfer($images, $kos_booking_id, $kode)
    {
        $folder = "bukti_transfer/".$kode;
        KosBuktiTransfer::where('kos_booking_id', $kos_booking_id)->delete();

        $data['kos_booking_id'] = $kos_booking_id;
        $data['photo_path'] = $this->fileHandlerService->storage($images, $folder);

        KosBuktiTransfer::create($data);
 
    }

    public function create($data) {        
        return $this->kosBookingRepository->create($data);
    }
}
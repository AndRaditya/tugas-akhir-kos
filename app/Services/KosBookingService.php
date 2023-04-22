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

        // foreach ($images as $image) {
            $data['kos_booking_id'] = $kos_booking_id;
            $data['photo_path'] = $this->fileHandlerService->storage($images, $folder);
            // $data['photo_path'] = $images->store('bukti_transfer', ['disk' => 'public']);
            KosBuktiTransfer::create($data);
        // }
    }

    public function create($data) {        
        return $this->kosBookingRepository->create($data);
    }
}
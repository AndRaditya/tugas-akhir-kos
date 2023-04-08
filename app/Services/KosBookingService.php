<?php

namespace App\Services;

use App\Repositories\KosBookingRepository;

class KosBookingService
{
    /** @var KosBookingRepository */
    private $kosBookingRepository;

    public function __construct(KosBookingRepository $kosBookingRepository){
        $this->kosBookingRepository = $kosBookingRepository;
    }

    public function getAll(){
        return $this->kosBookingRepository->getAll();
    }

    public function get($id){
        return $this->kosBookingRepository->get($id);
    }

    public function delete($id) {
        return $this->kosBookingRepository->delete($id);
    }
    
    public function update($id, $data) {
        return $this->kosBookingRepository->update($id, $data);
    }
    
    public function create($data) {        
        return $this->kosBookingRepository->create($data);
    }
}
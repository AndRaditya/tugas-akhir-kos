<?php

namespace App\Services;

use App\Repositories\KamarRepository;

class KamarService
{
    /** @var KamarRepository */
    private $kamarRepository;

    public function __construct(KamarRepository $kamarRepository){
        $this->kamarRepository = $kamarRepository;
    }

    public function getAll(){
        return $this->kamarRepository->getAll();
    }

    public function get($id){
        return $this->kamarRepository->get($id);
    }

    public function getKamarKosong(){
        return $this->kamarRepository->getKamarKosong();
    }

    public function delete($id) {
        return $this->kamarRepository->delete($id);
    }
    
    public function update($id, $data) {
        return $this->kamarRepository->update($id, $data);
    }
    
    public function create($data) {        
        return $this->kamarRepository->create($data);
    }
}
<?php

namespace App\Services;

use App\Repositories\KosRepository;

class KosService
{
    /** @var KosRepository */
    private $kosRepository;

    public function __construct(KosRepository $kosRepository){
        $this->kosRepository = $kosRepository;
    }

    public function getAll(){
        return $this->kosRepository->getAll();
    }

    public function get($id){
        return $this->kosRepository->get($id);
    }

    public function delete($id) {
        return $this->kosRepository->delete($id);
    }
    
    public function update($id, $data) {
        return $this->kosRepository->update($id, $data);
    }
    
    public function create($data) {        
        return $this->kosRepository->create($data);
    }
}
<?php

namespace App\Services;

use App\Repositories\TransaksiMasukRepository;

class TransaksiMasukService
{
    /** @var TransaksiMasukRepository */
    private $transaksiMasukRepository;

    public function __construct(TransaksiMasukRepository $transaksiMasukRepository){
        $this->transaksiMasukRepository = $transaksiMasukRepository;
    }

    public function getAll(){
        return $this->transaksiMasukRepository->getAll();
    }

    public function get($id){
        return $this->transaksiMasukRepository->get($id);
    }

    public function delete($id) {
        return $this->transaksiMasukRepository->delete($id);
    }
    
    public function update($id, $data) {
        return $this->transaksiMasukRepository->update($id, $data);
    }
    
    public function create($data) {        
        return $this->transaksiMasukRepository->create($data);
    }
}
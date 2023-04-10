<?php

namespace App\Services;

use App\Repositories\TransaksiKeluarRepository;

class TransaksiKeluarService
{
    /** @var TransaksiKeluarRepository */
    private $transaksiKeluarRepository;

    public function __construct(TransaksiKeluarRepository $transaksiKeluarRepository){
        $this->transaksiKeluarRepository = $transaksiKeluarRepository;
    }

    public function getAll(){
        return $this->transaksiKeluarRepository->getAll();
    }

    public function get($id){
        return $this->transaksiKeluarRepository->get($id);
    }

    public function delete($id) {
        return $this->transaksiKeluarRepository->delete($id);
    }
    
    public function update($id, $data) {
        return $this->transaksiKeluarRepository->update($id, $data);
    }
    
    public function create($data) {        
        return $this->transaksiKeluarRepository->create($data);
    }
}
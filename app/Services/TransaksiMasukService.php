<?php

namespace App\Services;

use App\Repositories\TransaksiMasukRepository;
use App\Models\KosBuktiTransfer;

class TransaksiMasukService
{
    /** @var TransaksiMasukRepository */
    private $transaksiMasukRepository;
    private $fileHandlerService;

    public function __construct(TransaksiMasukRepository $transaksiMasukRepository, FileHandlerService $fileHandlerService){
        $this->transaksiMasukRepository = $transaksiMasukRepository;
        $this->fileHandlerService = $fileHandlerService;
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

    public function insertBuktiTransfer($images, $transaksi_masuk_id, $kode)
    {
        $folder = "bukti_transfer_transaksi/".$kode;
        KosBuktiTransfer::where('transaksi_masuk_id', $transaksi_masuk_id)->delete();

        $data['transaksi_masuk_id'] = $transaksi_masuk_id;
        $data['photo_path'] = $this->fileHandlerService->storage($images, $folder);

        KosBuktiTransfer::create($data);
    }

    public function deleteBuktiTransfer($transaksi_masuk_id, $image){
        $photo_path = $image['photo_path'];
        
        return KosBuktiTransfer::where('transaksi_masuk_id', $transaksi_masuk_id)
            ->where('photo_path', $photo_path)
            ->delete();
    }

    public function getChart($tahun, $kategori){
        return $this->transaksiMasukRepository->getChart($tahun, $kategori);
    }
}
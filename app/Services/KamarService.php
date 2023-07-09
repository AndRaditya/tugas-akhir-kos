<?php

namespace App\Services;

use App\Models\KamarFasilitas;
use App\Models\KamarPhotos;
use App\Repositories\KamarRepository;

class KamarService
{
    /** @var KamarRepository */
    private $kamarRepository;
    private $fileHandlerService;

    public function __construct(KamarRepository $kamarRepository, FileHandlerService $fileHandlerService){
        $this->kamarRepository = $kamarRepository;
        $this->fileHandlerService = $fileHandlerService;
    }

    public function getAll(){
        return $this->kamarRepository->getAll();
    }

    public function get($id){
        return $this->kamarRepository->get($id);
    }

    public function getByNomor($id){
        return $this->kamarRepository->getByNomor($id);
    }

    public function getKamarKosong(){
        return $this->kamarRepository->getKamarKosong();
    }
    
    public function getKamarDipakai(){
        return $this->kamarRepository->getKamarDipakai();
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

    public function insertKamarPhotos($image, $kamar_id)
    {
        $folder = "kamar_photos/".$kamar_id;

        $data['kamar_id'] = $kamar_id;
        $data['photo_path'] = $this->fileHandlerService->storage($image['image_url'], $folder);

        KamarPhotos::create($data);
    }

    public function deleteKamarPhotos($kamar_id, $image){
        $photo_path = $image['photo_path'];
        
        return KamarPhotos::where('kamar_id', $kamar_id)
            ->where('photo_path', $photo_path)
            ->delete();
    }

    public function getKamarPhotos(){
        return KamarPhotos::whereHas('kamar', function ($q) {
                    $q->where('number', 1);
                })
                ->select('photo_path')
                ->get();
    }
    
    public function getFasilitasKamar(){
        return KamarFasilitas::select('name')
                ->get();
    }
    
    public function getNomorKamarWithNama(){
        return $this->kamarRepository->getNomorKamarWithNama();
    }
}
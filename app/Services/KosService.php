<?php

namespace App\Services;

use App\Models\KosPhotos;
use App\Repositories\KosRepository;

class KosService
{
    /** @var KosRepository */
    private $kosRepository;
    private $fileHandlerService;

    public function __construct(KosRepository $kosRepository, FileHandlerService $fileHandlerService){
        $this->kosRepository = $kosRepository;
        $this->fileHandlerService = $fileHandlerService;
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

    public function insertKosPhotos($images, $kos_id)
    {
        $folder = "kos_photos/".$kos_id;
        KosPhotos::where('kos_id', $kos_id)->delete();

        foreach($images as $image){
            $data['kos_id'] = $kos_id;
            $data['photo_path'] = $this->fileHandlerService->storage($image['image_url'], $folder);
    
            KosPhotos::create($data);
        }
    }

    public function deleteKosPhotos($kos_id, $image){
        $photo_path = $image['photo_path'];
        
        return KosPhotos::where('kos_id', $kos_id)
            ->where('photo_path', $photo_path)
            ->delete();
    }
}
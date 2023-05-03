<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\KamarService;
use App\Http\Controllers\Api\KamarFasilitasController;
use DB;
use Illuminate\Support\Facades\Schema;

class KamarController extends Controller
{
    private $kamarService;
    private $kamarFasilitasController;

    public function __construct(KamarService $kamarService, KamarFasilitasController $kamarFasilitasController)
    {
        $this->kamarService = $kamarService;
        $this->kamarFasilitasController = $kamarFasilitasController;
    }

    public function getAll()
    {
        $result = $this->kamarService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($id)
    {
        $result = $this->kamarService->get($id);
        return ResponseHelper::get($result);
    }

    public function getKamarKosong()
    {
        $result = $this->kamarService->getKamarKosong();
        return ResponseHelper::get($result);
    }

    public function getKamarDipakai()
    {
        $result = $this->kamarService->getKamarDipakai();
        return ResponseHelper::get($result);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){ 
            $kamar_photos = $request['kamar_photos'];

            $kamar_fasilitas = $request['kamar_fasilitas'];

            $data = $request->only(Schema::getColumnListing('kamars'));

            $kamar_id = $this->kamarService->create($data);
            
            foreach($kamar_fasilitas as $kamar_fasilitas_each){
                $this->kamarFasilitasController->create($kamar_fasilitas_each, $kamar_id);
            } 

            if(count($kamar_photos) > 0){
                foreach($kamar_photos as $kamar_photo){
                    $this->kamarService->insertKamarPhotos($kamar_photo, $kamar_id);
                }
            }

            return ResponseHelper::create($kamar_id);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $kamar_photos = $request['kamar_photos'];
            $kamar_fasilitas = $request['kamar_fasilitas'];

            $request = $request->only(Schema::getColumnListing('kamars'));
            $request['updated_at'] = now();

            $this->kamarFasilitasController->deleteSelected($id);
            
            foreach($kamar_fasilitas as $kamar_fasilitas_each){
                $this->kamarFasilitasController->create($kamar_fasilitas_each, $id);
            } 

            if(count($kamar_photos) > 0){
                foreach($kamar_photos as $kamar_photo){
                    if(count($kamar_photo) == 1){
                        $this->kamarService->insertKamarPhotos($kamar_photo, $id);
                    }
                }
            }
            
            $container = $this->kamarService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function updateStatusKamar($data){
        return DB::transaction(function () use ($data) {
            $data['updated_at'] = now();
            $container = $this->kamarService->update($data['id'], $data);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->kamarService->delete($id);
        return ResponseHelper::delete();
    }

    public function deleteKamarPhotos($id, Request $request)
    {
        $photo = $request->kamar_photos;
        if ($photo) {
            return $this->kamarService->deleteKamarPhotos($id, $photo);
        }
    }


}
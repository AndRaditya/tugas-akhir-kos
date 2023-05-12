<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\KamarService;
use App\Http\Controllers\Api\KamarFasilitasController;
use App\Models\Kamar;
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
            $number = $data['number'];
            
            $kamar_db = Kamar::where('number', '=', $number)->first();

            if($kamar_db == null){
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
            }else{
                $error['message'] = 'Kamar Nomor ' . $number . ' sudah ada';
                
                return ResponseHelper::error($error);
            }

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

    public function updateStatusKamar($data, $kos_booking_id){
        return DB::transaction(function () use ($data, $kos_booking_id) {
            $data['updated_at'] = now();
            $data['kos_booking_id'] = $kos_booking_id;
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

    public function getKamarPhotos(){
        $result = $this->kamarService->getKamarPhotos();

        return ResponseHelper::get($result);
    }

    public function getFasilitasKamar(){
        $result = $this->kamarService->getFasilitasKamar();
        
        $fasilitas = [];
        foreach($result as $data){
            array_push($fasilitas, $data['name']);
        }

        $fasilitas = array_unique($fasilitas);

        return ResponseHelper::get($fasilitas);
    }

    public function getNomorKamarWithNama(){
        $result = $this->kamarService->getNomorKamarWithNama();

        return ResponseHelper::get($result);
    }


}
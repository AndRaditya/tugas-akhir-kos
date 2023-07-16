<?php

namespace App\Http\Controllers\Api;

use App\Services\KosService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseHelper;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Api\KamarSpesifikasiController;
use App\Http\Controllers\Api\KosFasilitasController;
use App\Models\Kos;
use Illuminate\Support\Facades\Storage;

class KosController extends Controller
{
    private $kosService;
    private $kamarSpesifikasiController;
    private $kosFasilitasController;

    public function __construct(KosService $kosService, KamarSpesifikasiController $kamarSpesifikasiController, KosFasilitasController $kosFasilitasController)
    {
        $this->kosService = $kosService;
        $this->kamarSpesifikasiController = $kamarSpesifikasiController;
        $this->kosFasilitasController = $kosFasilitasController;
    }

    public function getAll()
    {
        $result = $this->kosService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($id)
    {
        $result = $this->kosService->get($id);
        return ResponseHelper::get($result);
    }

    public function getDataList(){
        $result = $this->kosService->getAll();

        $result->transform(function ($d) {
            return [
                $d->name
            ];
        });

        return $result;
    }

    public function create(Request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('kos'));
            $kosQuery = $this->kosService->create($data);
            return ResponseHelper::create($kosQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $kamarSpecs = $request['kamar_spesifikasi'];
            $fasilitas = $request['kos_fasilitas'];
            $kos_photos = $request['kos_photos'];

            if(count($kos_photos) > 0){
                foreach($kos_photos as $kos_photo){
                    if(count($kos_photo) == 1){
                        $this->kosService->insertKosPhotos($kos_photo, $id);
                    }
                }
            }

            $request = $request->only(Schema::getColumnListing('kos'));
            $request['updated_at'] = now();

            $this->kamarSpesifikasiController->deleteSelected($id);
            $this->kosFasilitasController->deleteSelected($id);
            
            foreach($kamarSpecs as $kamarSpec){
                $this->kamarSpesifikasiController->create($kamarSpec, $id);
            } 
            
            foreach($fasilitas as $eachFasilitas){
                $this->kosFasilitasController->create($eachFasilitas, $id);
            } 

            $container = $this->kosService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->kosService->delete($id);
        return ResponseHelper::delete();
    }
    
    public function deleteKosPhotos($id, Request $request)
    {
        $photo = $request->kos_photos;
        if ($photo) {
            return $this->kosService->deleteKosPhotos($id, $photo);
        }
    }
}
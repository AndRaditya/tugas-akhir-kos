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

    public function __construct(KosService $kosService)
    {
        $this->kosService = $kosService;
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
            $request = $request->only(Schema::getColumnListing('kos'));
            $request['updated_at'] = now();


            $container = $this->kosService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->kosService->delete($id);
        return ResponseHelper::delete();
    }

}
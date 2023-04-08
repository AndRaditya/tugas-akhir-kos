<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Services\KamarService;
use DB;
use Illuminate\Support\Facades\Schema;

class KamarController extends Controller
{
    private $kamarService;

    public function __construct(KamarService $kamarService)
    {
        $this->kamarService = $kamarService;
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

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('kamars'));
            $kamarQuery = $this->kamarService->create($data);
            return ResponseHelper::create($kamarQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($id, $request) {
            $request = $request->only(Schema::getColumnListing('kamars'));
            $request['updated_at'] = now();

            $container = $this->kamarService->update($id, $request);

            return ResponseHelper::put($container);
        });
    }

    public function delete($id)
    {
        $this->kamarService->delete($id);
        return ResponseHelper::delete();
    }


}
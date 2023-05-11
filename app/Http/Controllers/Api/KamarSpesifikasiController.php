<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\KamarSpesifikasi;
use DB;

class KamarSpesifikasiController extends Controller
{
    public function create($data, $id){
        return DB::transaction(function () use ($data, $id){
            // KamarSpesifikasi::where('kos_id', $id)->delete();

            $data['kos_id'] = $id;
            
            $kamarSpecQuery = KamarSpesifikasi::updateOrCreate($data);
            return ResponseHelper::create($kamarSpecQuery);
        });
    }

    public function getKosId($id)
    {
        $result = KamarSpesifikasi::where('kos_id', $id)->get();

        return ResponseHelper::get($result);
    }

    public function deleteSelected($id){
        KamarSpesifikasi::where('kos_id', $id)->delete();
    }
}
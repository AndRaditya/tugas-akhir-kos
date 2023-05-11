<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KosFasilitas;
use App\Helpers\ResponseHelper;
use DB;

class KosFasilitasController extends Controller
{

    public function getAll()
    {
        $result = KosFasilitas::get();

        return ResponseHelper::get($result);
    }

    public function create($data, $id){
        return DB::transaction(function () use ($data, $id){
            // KosFasilitas::where('kos_id', $id)->delete();
            $fasilitas['name'] = $data;
            $fasilitas['kos_id'] = $id;
            
            $kosFasilitasQuery = KosFasilitas::updateOrCreate($fasilitas);
            return ResponseHelper::create($kosFasilitasQuery);
        });
    }

    public function deleteSelected($id){
        KosFasilitas::where('kos_id', $id)->delete();
    }
}
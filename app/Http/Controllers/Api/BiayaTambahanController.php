<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Models\BiayaTambahan;
use DB;

class BiayaTambahanController extends Controller
{
    public function create($data, $id){
        return DB::transaction(function () use ($data, $id){
            $biaya_tambahan['name'] = $data['name'];
            $biaya_tambahan['transaksi_masuk_id'] = $id;
            $biaya_tambahan['desc'] = $data['desc'];
            $biaya_tambahan['nilai'] = $data['nilai'];

            
            $biayaTambahanQuery = BiayaTambahan::updateOrCreate($biaya_tambahan);
            return ResponseHelper::create($biayaTambahanQuery);
        });
    }

    public function deleteSelected($id){
        BiayaTambahan::where('transaksi_masuk_id', $id)->delete();
    }
}
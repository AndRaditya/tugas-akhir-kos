<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiKeluarKategori;
use Illuminate\Http\Request;

class TransaksiKeluarKategoriController extends Controller
{
    public function getDataList(){
        $result = TransaksiKeluarKategori::get();

        $result->transform(function ($d) {
            return [
                'text' => $d->name,
                'value' => $d->id,
            ];
        });
        return $result;
    }
}
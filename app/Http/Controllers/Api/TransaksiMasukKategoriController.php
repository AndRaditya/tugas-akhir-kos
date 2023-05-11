<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiMasukKategori;
use Illuminate\Http\Request;

class TransaksiMasukKategoriController extends Controller
{
    public function getDataList(){
        $result = TransaksiMasukKategori::get();

        $result->transform(function ($d) {
            return [
                'text' => $d->name,
                'value' => $d->id,
            ];
        });
        return $result;
    }
}
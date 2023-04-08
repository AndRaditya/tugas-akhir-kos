<?php

namespace App\Services;

use App\Models\KosBooking;

class NumberGeneratorService
{
    public function generateNumber($type){
        if($type == 'BOOK'){
            $kode = "BOOK-";
            $currentTime = now()->format('ymd');
            $numberPrefix = $kode.$currentTime;

            $container = KosBooking::where('kode','like',$numberPrefix.'%')->orderBy('kode','desc')->first();
    
            if($container) {
                $counter = (int)(explode($numberPrefix,$container->kode)[1])+1;
                return $numberPrefix.sprintf('%03d',$counter);
            }
    
            return $numberPrefix.'001';
        }

        if($type == 'TRSOUT'){
            $kode = "TRSOUT-";
        }

        if($type == 'TRSIN'){
            $kode = "TRSIN-";
        }
    }
}
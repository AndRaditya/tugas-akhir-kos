<?php

namespace App\Services;

use App\Models\KosBooking;
use App\Models\TransaksiKeluar;
use App\Models\TransaksiMasuk;

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
            $no = "TRSOUT-";
            $currentTime = now()->format('ymd');
            $numberPrefix = $no.$currentTime;

            $container = TransaksiKeluar::where('no','like',$numberPrefix.'%')->orderBy('no','desc')->first();
    
            if($container) {
                $counter = (int)(explode($numberPrefix,$container->no)[1])+1;
                return $numberPrefix.sprintf('%03d',$counter);
            }
    
            return $numberPrefix.'001';
        }

        if($type == 'TRSIN'){
            $no = "TRSIN-";
            $currentTime = now()->format('ymd');
            $numberPrefix = $no.$currentTime;

            $container = TransaksiMasuk::where('no','like',$numberPrefix.'%')->orderBy('no','desc')->first();
    
            if($container) {
                $counter = (int)(explode($numberPrefix,$container->no)[1])+1;
                return $numberPrefix.sprintf('%03d',$counter);
            }
    
            return $numberPrefix.'001';
        }
    }
}
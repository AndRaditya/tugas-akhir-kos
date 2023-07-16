<?php

namespace App\Repositories;

use App\Models\TransaksiMasuk as TransaksiMasukModel;

class TransaksiMasukRepository implements Repository
{
    CONST PRIMARY_KEY = 'id';
        
    private $transaksiMasukModel;

    public function __construct(TransaksiMasukModel $transaksiMasukModel)
    {
        $this->transaksiMasukModel = $transaksiMasukModel;
    }

    public function get($id){
        return $this->transaksiMasukModel
                    ->with('transaksi_masuk_kategori')
                    ->with('biaya_tambahan')
                    ->with('bukti_transfer')
                    ->with('kos_booking')
                    ->where('id',$id)->get();
    }

    public function getAll(){
        return $this->transaksiMasukModel
                        ->with('transaksi_masuk_kategori')
                        ->with('biaya_tambahan')
                        ->get();
    }

    public function create($data)
    {
        return $this->transaksiMasukModel::create($data)->id;
    }

    public function update($id, $data)
    {
        return $this->transaksiMasukModel::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->transaksiMasukModel::where(self::PRIMARY_KEY, $id)->delete();
    }

    public function getChart($tahun, $kategori){
        return $this->transaksiMasukModel
                    ->whereYear('tanggal', $tahun)
                    ->with('transaksi_masuk_kategori')
                    ->whereHas('transaksi_masuk_kategori', function ($q) use ($kategori){
                        $q->where('name', "like", '%' . $kategori . '%');
                    })
                    ->get()
                    ->groupBy(function($item){
                        return $item->tanggal->format('m');
                    });
    }
}
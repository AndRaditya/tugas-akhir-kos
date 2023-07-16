<?php

namespace App\Repositories;

use App\Models\TransaksiKeluar as TransaksiKeluarModel;

class TransaksiKeluarRepository implements Repository
{
    CONST PRIMARY_KEY = 'id';
        
    private $transaksiKeluarModel;

    public function __construct(TransaksiKeluarModel $transaksiKeluarModel)
    {
        $this->transaksiKeluarModel = $transaksiKeluarModel;
    }

    public function get($id){
        return $this->transaksiKeluarModel
                    ->with('transaksi_keluar_kategori')
                    ->where('id',$id)->get();
    }

    public function getAll(){
        return $this->transaksiKeluarModel
                        ->with('transaksi_keluar_kategori')
                        ->get();
    }

    public function create($data)
    {
        return $this->transaksiKeluarModel::create($data)->id;
    }

    public function update($id, $data)
    {
        return $this->transaksiKeluarModel::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->transaksiKeluarModel::where(self::PRIMARY_KEY, $id)->delete();
    }

    public function getChart($tahun, $kategori){
        return $this->transaksiKeluarModel
                    ->whereYear('tanggal', $tahun)
                    ->with('transaksi_keluar_kategori')
                    ->whereHas('transaksi_keluar_kategori', function ($q) use ($kategori){
                        $q->where('name', "like", '%' . $kategori . '%');
                    })
                    ->get()
                    ->groupBy(function($item){
                        return $item->tanggal->format('m');
                    });
    }
}
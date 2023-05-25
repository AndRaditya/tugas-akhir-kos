<?php

namespace App\Repositories;

use App\Models\Kos as KosModel;

class KosRepository implements Repository
{
    CONST PRIMARY_KEY = 'id';
        
    private $kosModel;

    public function __construct(KosModel $kosModel)
    {
        $this->kosModel = $kosModel;
    }

    public function get($id){
        return $this->kosModel->where('id',$id)
                    ->with('kamar_spesifikasi')
                    ->with('kamar')
                    ->with('kos_fasilitas')
                    ->with('kos_photos')
                    ->get();
    }

    public function getAll(){
        return $this->kosModel->get();
    }

    public function create($data)
    {
        return $this->kosModel::create($data)->id;
    }

    public function update($id, $data)
    {
        return $this->kosModel::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->kosModel::where(self::PRIMARY_KEY, $id)->delete();
    }

}
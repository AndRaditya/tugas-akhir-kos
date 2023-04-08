<?php

namespace App\Repositories;

use App\Models\Kamar as KamarModel;

class KamarRepository implements Repository
{
    CONST PRIMARY_KEY = 'id';
        
    private $kamarModel;

    public function __construct(KamarModel $kamarModel)
    {
        $this->kamarModel = $kamarModel;
    }

    public function get($id){
        return $this->kamarModel->where('id',$id)
                    ->with('user')
                    ->with('kamar_fasilitas')
                    ->with('kamar_photos')
                    ->get();
    }

    public function getAll(){
        return $this->kamarModel
                    ->with('user')
                    ->with('kamar_fasilitas')
                    ->get();
    }

    public function create($data)
    {
        return $this->kamarModel::create($data)->id;
    }

    public function update($id, $data)
    {
        return $this->kamarModel::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->kamarModel::where(self::PRIMARY_KEY, $id)->delete();
    }

}
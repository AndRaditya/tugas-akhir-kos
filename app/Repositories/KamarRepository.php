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
                    ->with('kamar_fasilitas')
                    ->with('kamar_photos')
                    ->get();
    }

    public function getAll(){
        return $this->kamarModel
                    ->with('kamar_fasilitas')
                    ->get();
    }
    
    public function getKamarKosong(){
        return $this->kamarModel
                    ->where('status', '=', 'Kosong')
                    ->get();
    }

    public function getKamarDipakai(){
        return $this->kamarModel
                    ->where('status', '=', 'Dipakai')
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
    
    public function getNomorKamarWithNama()
    {
        return $this->kamarModel
                    ->select(array('number', 'nama_penyewa'))
                    ->orderBy('number', 'asc')
                    ->get();
    }

}
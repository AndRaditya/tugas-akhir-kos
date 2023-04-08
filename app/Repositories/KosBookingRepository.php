<?php

namespace App\Repositories;

use App\Models\KosBooking as KosBookingModel;

class KosBookingRepository implements Repository
{
    CONST PRIMARY_KEY = 'id';
        
    private $kosBookingModel;

    public function __construct(KosBookingModel $kosBookingModel)
    {
        $this->kosBookingModel = $kosBookingModel;
    }

    public function get($id){
        return $this->kosBookingModel->where('id',$id)
                    ->with('user')
                    ->with('kamar')
                    ->get();
    }

    public function getAll(){
        return $this->kosBookingModel                    
                    ->with('user')
                    ->with('kamar')
                    ->get();
    }

    public function create($data)
    {
        return $this->kosBookingModel::create($data)->id;
    }

    public function update($id, $data)
    {
        return $this->kosBookingModel::find($id)->update($data);
    }

    public function delete($id)
    {
        return $this->kosBookingModel::where(self::PRIMARY_KEY, $id)->delete();
    }

}
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
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->orderBy('date', 'DESC')
                    ->get();
    }

    public function getByUser($user_id){
        return $this->kosBookingModel->where('users_id',$user_id)
                    ->with('user')
                    ->with('kamar')
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->orderBy('date', 'DESC')
                    ->get();
    }

    public function getByStatusByUser($user_id){
        return $this->kosBookingModel->where('users_id',$user_id)
                    ->with('user')
                    ->with('kamar')
                    ->orderBy('date', 'DESC')
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

    public function searchPaginate($keyword, $user_id){
        if($user_id){
            $container = $this->kosBookingModel
                        ->where('users_id', $user_id)
                        ->with('user', 'kamar')
                        ->orWhereHas('user', function ($q) use ($keyword){
                            $q->where('name', "like", '%' . $keyword . '%');
                        })
                        ->orWhereHas('kamar', function ($q) use ($keyword){
                            $q->where('number', "like", '%' . $keyword . '%');
                        })
                        ->where(function ($q) use ($keyword){
                            $q->where('kode', "like", "%" . $keyword . "%");
                            $q->orWhere('date', "like", "%" . $keyword . "%");
                            $q->orWhere('tanggal_mulai', "like", "%" . $keyword . "%");
                            $q->orWhere('tanggal_selesai', "like", "%" . $keyword . "%");
                            $q->orWhere('total_bulan', "like", "%" . $keyword . "%");
                            $q->orWhere('total_kamar', "like", "%" . $keyword . "%");
                            $q->orWhere('status', "like", "%" . $keyword . "%");
                            $q->orWhere('total_price', "like", "%" . $keyword . "%");
                        })
                        ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                        ->orderBy('date', 'DESC')
                        ->get();
        }else{
            $container = $this->kosBookingModel::
                        with('user', 'kamar')
                        ->whereHas('user', function ($q) use ($keyword){
                            $q->where('name', "like", '%' . $keyword . '%');
                        })
                        ->orWhereHas('kamar', function ($q) use ($keyword){
                            $q->where('number', "like", '%' . $keyword . '%');
                        })
                        ->orWhere(function ($q) use ($keyword){
                            $q->where('kode', "like", "%" . $keyword . "%");
                            $q->orWhere('date', "like", "%" . $keyword . "%");
                            $q->orWhere('tanggal_mulai', "like", "%" . $keyword . "%");
                            $q->orWhere('tanggal_selesai', "like", "%" . $keyword . "%");
                            $q->orWhere('total_bulan', "like", "%" . $keyword . "%");
                            $q->orWhere('total_kamar', "like", "%" . $keyword . "%");
                            $q->orWhere('status', "like", "%" . $keyword . "%");
                            $q->orWhere('total_price', "like", "%" . $keyword . "%");
                        })
                        ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                        ->orderBy('date', 'DESC')
                        ->get();
        }

        return $container;        
    }

    public function getSortData($data, $user_id){
        if($user_id){
            if($data['jenis'] == 'date'){
                return $this->kosBookingModel                    
                    ->where('users_id', $user_id)
                    ->with('user')
                    ->with('kamar')
                    ->orderBy('date', $data['sort'])
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->get();
            }else if($data['jenis'] == 'total_price'){
                return $this->kosBookingModel                    
                    ->where('users_id', $user_id)
                    ->with('user')
                    ->with('kamar')
                    ->orderBy('total_price', $data['sort'])
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->get();
            }else{
                return $this->kosBookingModel                    
                        ->where('users_id', $user_id)
                        ->with('user')
                        ->with('kamar')
                        ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                        ->orderBy('date', $data['sort'])
                        ->get();
            }
        }else{
            if($data['jenis'] == 'date'){
                return $this->kosBookingModel                    
                    ->with('user')
                    ->with('kamar')
                    ->orderBy('date', $data['sort'])
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->get();
            }else if($data['jenis'] == 'total_price'){
                return $this->kosBookingModel                    
                    ->with('user')
                    ->with('kamar')
                    ->orderBy('total_price', $data['sort'])
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->get();
            }else{
                return $this->kosBookingModel                    
                    ->with('user')
                    ->with('kamar')
                    ->orderByRaw("FIELD(status , 'Menunggu Konfirmasi Pengelola', 'Terkonfirmasi', 'Dibatalkan') ASC")
                    ->orderBy('date', $data['sort'])
                    ->get();
            }
        }

    }

}
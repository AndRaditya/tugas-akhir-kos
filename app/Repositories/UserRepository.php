<?php

namespace App\Repositories;

use App\Models\User as UserModel;

class UserRepository implements Repository
{
    CONST PRIMARY_KEY = 'id';
        
    private $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

	public function getByEmail($email)
    {
        return $this->userModel->where('email', $email)->whereNull('deleted_at');
    }

    public function get($user_id){
      	return $this->userModel->where('id',$user_id)
            ->with('user_role')
            ->get()
            ->makeHidden(['firebase_token']);
    }
    
    public function getPengelola(){
      	return $this->userModel->where('roles_id', 1)->first();
    }

    public function getPassword($user_id){
      	return $this->userModel->where('id',$user_id)->select('password')->get();
    }
    
    public function getFirebaseToken($id, $role_name){
      	return $this->userModel
                    ->where('id',$id)
                    ->whereHas('user_role', function ($q) use ($role_name){
                        $q->where('name', "like", '%' . $role_name . '%');
                    })
                    ->select('firebase_token')->first();
    }

    public function getAll(){
      	return $this->userModel->get()->makeHidden(['firebase_token']);
    }

    public function create($data) {
      	return $this->userModel::create($data)->id;
    }

    public function update($id, $data) {
      	return $this->userModel::where(self::PRIMARY_KEY,$id)->update($data);
    }

    public function delete($id) {
      	return $this->userModel::where(self::PRIMARY_KEY,$id)->delete();
    }
}
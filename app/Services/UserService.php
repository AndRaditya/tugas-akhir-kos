<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function changePassword($userId, $newPassword, $oldPassword)
    {
        $userData = $this->userRepository->get($userId)->first();

        if (!Hash::check($oldPassword, $userData->password)) {
            return false;
        }

        $this->userRepository->update($userId, [
            'password' => Hash::make($newPassword),
        ]);

        return true;
    }

    public function getAll(){
        return $this->userRepository->getAll();
    }

    public function get($user_id){
        return $this->userRepository->get($user_id);
    }
    
    public function getPengelola(){
        return $this->userRepository->getPengelola();
    }

    public function getPassword($user_id){
        return $this->userRepository->getPassword($user_id);
    }

    public function delete($id) {
        return $this->userRepository->delete($id);
    }
    
    public function update($id,$data) {
        return $this->userRepository->update($id, $data);
    }
    
    public function create($data) {        
        return $this->userRepository->create($data);
    }

}
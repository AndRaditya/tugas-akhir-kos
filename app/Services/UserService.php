<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function getAll(){
        return $this->userRepository->getAll();
    }

    public function get($user_id){
        return $this->userRepository->get($user_id);
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
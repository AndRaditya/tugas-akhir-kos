<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Hash;
use App\Repositories\UserRepository;

class AuthenticationService
{
  private $userRepository;

	public function __construct(UserRepository $userRepository)
	{
		$this->userRepository = $userRepository;
	}

    public function authenticate($email, $password)
    {
        if (!$userData = $this->userRepository->getByEmail($email)->first()) {
            return false;
        }

        if (!Hash::check($password, $userData->password)) {
            return false;
        }

        return $userData;
    }
}
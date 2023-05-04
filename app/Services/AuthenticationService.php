<?php

namespace App\Services;


use Hash;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redis;

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

    public function generateToken()
    {
        return md5(rand(1, 10) . microtime());
    }

    public function setTokenData($key, $value)
    {
        Redis::set($key, json_encode($value));
    }

    public function getTokenData($key)
    {
        return (array) (json_decode(Redis::get($key)));
    }

    public function removeToken($key)
    {
        return Redis::del($key);
    }
}
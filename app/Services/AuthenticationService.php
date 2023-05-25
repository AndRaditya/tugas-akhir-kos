<?php

namespace App\Services;


use Hash;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Redis;
use Firebase\JWT\JWT;

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

    public function firebaseToken(){
        $uid = 'nNFcbN7QunMs3Y2UAdzjtx5LqeC2'; 
        $is_premium_account = $uid;

        $service_account_email = env('SERVICE_ACCOUNT_EMAIL'); 
        $private_key = env('SERVICE_PRIVATE_KEY');
    
        $now_seconds = time();
        $payload = array(
            "iss" => $service_account_email,
            "sub" => $service_account_email,
            "aud" => "https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit",
            "iat" => $now_seconds,
            // "exp" => ,  // Maximum expiration time is one hour
            "uid" => $uid
        );

        return JWT::encode($payload, $private_key, "RS256");
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
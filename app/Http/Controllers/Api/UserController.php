<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AuthenticationService;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ResponseHelper;



class UserController extends Controller
{
    
    private $userService;
    private $authenticationService;

    public function __construct(AuthenticationService $authenticationService, UserService $userService)
    {
        $this->userService = $userService;
        $this->authenticationService = $authenticationService;

    }

    public function login(Request $request)
    {
        $authenticatedUserData = $this->authenticationService->authenticate($request->email, $request->password);

        if (!$authenticatedUserData) {
            return [
                'api_status' => 'fail',
                'api_title' => "Email or Password doesn't match!",
                'api_message' => "Please enter your matching login credential!!",
            ];
        }

        return [
            'api_status' => 'success',
            'data' => [$authenticatedUserData],
        ];
    }

    public function getAll()
    {
        $result = $this->userService->getAll();

        return ResponseHelper::get($result);
    }

    public function get($user_id)
    {
        $result = $this->userService->get($user_id);
        return ResponseHelper::get($result);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('users'));
            $data['roles_id'] = 2;
            $userQuery = $this->userService->create($data);
            return ResponseHelper::create($userQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($request, $id) {
            $result = $this->putData($id, $request, $request->only(Schema::getColumnListing('users')));
            // dd($result);
            
            $userData = $request->_session;
            if($userData['id'] == $id){
                $userData = $this->userService->get($id)[0];
            }
            return ResponseHelper::put($result);
        });
    }

    public function putData($id, Request $request, $data)
    {
        $data["id"] = $id;  //Do not change ID here!!!
        unset($data["password"]); //Do not change password here!!!

        unset($data["created_at"]);
        unset($data["deleted_at"]);
        $data["updated_at"] = now();

        $this->userService->update($id, $data);
        return true;
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        return ResponseHelper::delete();
    }

}
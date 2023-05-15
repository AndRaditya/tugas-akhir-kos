<?php

namespace App\Http\Controllers\Api;

use App\Events\ForgotPassword;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\AuthenticationService;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Schema;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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

        $token = $this->authenticationService->generateToken();
        $this->authenticationService->setTokenData($token, $authenticatedUserData);
        return [
            'api_status' => 'success',
            'api_message' => $token,
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

    public function getPengelola()
    {
        $result = $this->userService->getPengelola();
        return ResponseHelper::get($result);
    }

    public function changePassword(Request $request)
    {
        $permited = true;
  
        if ($permited) {
            $isSuccess = $this->userService->changePassword(
                $request->id,
                $request->newPassword,
                $request->oldPassword
            );
            if (!$isSuccess) {
                return response()->json([
                    'api_status' => "fail",
                    'message' => 'Your old Password mismatch!!'
                ]);
            }
            return response()->json([
                'api_status' => "success",
                'message' => 'Your Password updated!!'
            ]);
        }
        return response()->json([
            'api_status' => "fail",
            'message' => 'You are unauthorized!!'
        ]);
    }

    public function create(request $request){
        return DB::transaction(function () use ($request){
            $data = $request->only(Schema::getColumnListing('users'));
            $hashPassword = Hash::make($data['password']);
            $data['password'] = $hashPassword;
            $data['roles_id'] = 2;
            $userQuery = $this->userService->create($data);
            return ResponseHelper::create($userQuery);
        });
    }

    public function update($id, Request $request)
    {
        return DB::transaction(function () use ($request, $id) {
            $result = $this->putData($id, $request, $request->only(Schema::getColumnListing('users')));
            
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

    public function forgotPassword(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|exists:users,email'
        ]);

        if ($validation->fails()) {
            return response("Email doesn't exist!", 400);
        }

        $user = User::where("email", $request->email)->first();

        event(new ForgotPassword($user));

        return response("Link Lupa Password sudah terkirim, jika Anda tidak menerima email, mungkin berada di folder Spam", 200);
    }

    public function forgotPasswordView(){
        return view('ResetPassword');
    }

    public function delete($id)
    {
        $this->userService->delete($id);
        return ResponseHelper::delete();
    }

}
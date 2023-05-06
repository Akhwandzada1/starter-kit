<?php

namespace App\Repository\RegisterManagement;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repository\UserManagement\UserManagementInterface;

class Register implements RegisterManagementInterface {

    public $repositoryObj;
    
    public function __construct(UserManagementInterface $repositoryObj){
        $this->repositoryObj = $repositoryObj;
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:users,name',
            'password' => 'required',
            'email' => 'required|unique:users,email'
        ]);

        if($validator->fails()){
            $error = $validator->errors()->all();
            $response = [
                'success' => false,
                'message' => $error
            ];

            return $response;
        } else {
            $response = $this->repositoryObj->store($request);
            
            return $response;
        }
    }

    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();

            $abilitiesName = $user->getAbilitiesName();
            $token = $user->createToken('MyApp', $abilitiesName)->plainTextToken;
            $response["success"] = true;
            $response["accessToken"] = $token;
            $response["refreshToken"] = $token;
            $response["name"] = $user->name;
            $response["email"] = $user->email;
            $response["role"] = $user->getRoleNames();
            $response["abilities"] = $user->getAbilities();
            $response["message"] = "User login successful";
        } else {
            $response["success"] = false;
            $response["message"] = "Access denied";
        }

        return $response;
    }
}
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repository\RegisterManagement\RegisterManagementInterface;

class RegisterController extends Controller
{
    public $repositoryObj;

    public function __construct(RegisterManagementInterface $registerObj){
        $this->repositoryObj = $registerObj;
    }

    public function register(Request $request){
        $response = $this->repositoryObj->register($request);

        if(! $response["success"]){
            return response()->json($response, 400);
        }

        return response()->json($response, 200);
    }

    public function login(Request $request){
        $response = $this->repositoryObj->login($request);

        if(! $response["success"]){
            return response()->json($response, 401);
        }
        return response()->json($response, 200);
    }
}

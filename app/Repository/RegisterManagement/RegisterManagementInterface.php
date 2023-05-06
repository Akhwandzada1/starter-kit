<?php

namespace App\Repository\RegisterManagement;

use Illuminate\Http\Request;

interface RegisterManagementInterface {

    //This method will be used to register user. 
    public function register(Request $request);

    //This method will be used to authenticate the user
    public function login(Request $request);


}
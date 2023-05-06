<?php

namespace App\Repository\UserManagement;

use Illuminate\Http\Request;
use App\Models\User as Users;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


class User implements UserManagementInterface{
    
    public function index(Request $request){
        $users = Users::paginate(10);

        if($users->isEmpty()){
            $response["success"] = false;
            $response["message"] = "No User found";
        } else {
            $response["success"] = true;
            $response["message"] = "Users found successfully";
            $response["data"] = $user;
        }

        return $response;
    }

    public function store(Request $request){
        $user = new Users;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        $roleId = $request->role;
        $role = Role::find($roleId);
        $user->assignRole($role);

        if(! $user){
            $response["success"] = false;
            $response["message"] = "Failed to save data";
        } else {
            $response["success"] = true;
            $response["message"] = "User created successfully";
            $response["data"] = $user;
        }

        return $response;

    }

    public function update($id, Request $request){
        $user = Users::find($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        if(! $user){
            $response["success"] = false;
            $response["message"] = "Failed to update data";
        } else {
            $response["success"] = true;
            $response["message"] = "User data updated successfully";
            $response["data"] = $user;
        }

        return $response;
    }

    public function destroy($id){
        $user = Users::find($id);

        if($user->isEmpty()){
            $response["success"] = false;
            $response["message"] = "No Result found";
        } else if($user->hasRole('super_admin')){
            $response["success"] = false;
            $response["message"] = "Cannot delete Super Admin";
        } else {
            $user->delete();
            $response["success"] = true;
            $response["message"] = "User deleted successfully";
            $response["data"] = $user;
        }

        return $response;
    }
}
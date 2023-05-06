<?php

namespace App\Repository\RoleManagement;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as Roles;
use App\Models\User;

class Role implements RoleManagementInterface {
    
    public function index(Request $request){
        if($request->roleName != null){
            $roles = Roles::where(function($query) use ($request){
                return $query->where('name', 'LIKE', '%'.$request->roleName.'%');
            })->get();

            if($roles->isEmpty()){
                $response["success"] = false;
                $response["message"] = "No roles found";
            } else {
                $response["success"] = true;
                $response["message"] = "Roles found successfully";
                $response["data"] = $roles;
            }
        } else {
            $roles = Roles::all();

            if($roles->isEmpty()){
                $response["success"] = false;
                $response["message"] = "No roles found";
            } else {
                $response["success"] = true;
                $response["message"] = "Roles found successfully";
                $response["data"] = $roles;
            }
        }

        return $response;
    }

    public function store(Request $request){
        $role = Roles::create(['name' => $request->roleName]);
        if(! $role){
            $response["success"] = false;
            $response["message"] = "Role not created";
        } else {
            $response["success"] = true;
            $response["message"] = "Role created successfully";
            $response["data"] = $role;
        }

        return $response;
    }

    public function update($id, Request $request){
        $role = Roles::find($id);

        if($role->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Role not found";
        } else {
            $role->name = $request->roleName;
            $role->save();
            $response["success"] = true;
            $response["message"] = "Role updated successfully";
            $response["data"] = $role;
        }

        return $response;
    }

    public function destroy($id){
        $role = Roles::find($id);

        if($role->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Role not found";
        } else {
            $role->delete();
            $response["success"] = true;
            $response["message"] = "Role deleted successfully";
            $response["data"] = $role;
        }

        return $response;
    }

    public function assignRoleToUser($userId, $roleId){
        $role = Roles::find($roleId);
        $user = User::find($userId);

        if($role->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Role not found";
        } else {
            $user->assignRole($role);
            $response["success"] = true;
            $response["message"] = "Role assigned to user successfully";
            $response["data"]["role"] = $role;
            $response["data"]["user"] = $user;
        }

        return $response;
    }

    public function revokeRoleFromUser($userId, $roleId){
        $role = Roles::find($roleId);
        $user = User::find($userId);

        if($role->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Role not found";
        } else {
            $user->removeRole($role);
            $response["success"] = true;
            $response["message"] = "Role revoked from user successfully";
            $response["data"]["role"] = $role;
            $response["data"]["user"] = $user;
        }

        return $response;
    }
}
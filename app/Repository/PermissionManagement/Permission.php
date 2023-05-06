<?php

namespace App\Repository\PermissionManagement;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as Permissions;
use Spatie\Permission\Models\Role;

class Permission implements PermissionManagementInterface{

    public function index(Request $request){
        if($request->permissionName != null){
            $permissions = Permissions::where(function ($query) use ($request){
                return $query->where('name', 'LIKE', '%'.$request->permissionName.'%');
            })
            ->get();

            if($permissions->isEmpty()){
                $response["success"] = false;
                $response["message"] = "No permissions found !";
            } else {
                $response["success"] = true;
                $response["message"] = "Permissions found successfully";
                $response["data"] = $permissions;
            }
        } else {
            $permissions = Permissions::all();

            if($permissions->isEmpty()){
                $response["success"] = false;
                $response["message"] = "No permissions found";
            } else {
                $response["success"] = true;
                $response["message"] = "Permissions found successfully";
                $response["data"] = $permissions;
            }
        }

        return $response;
    }

    public function destroy($id){
        $permission = Permissions::find($id);

        if($permission->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Permission doesn't exist";
        } else {
            $permission->delete();
            $response["success"] = true;
            $response["message"] = "Permission deleted successfully";
            $response["data"] = $permission;
        }

        return $response;
    }

    public function createPermission(Request $request){
        $permission = Permissions::create(['name' => $request->permissionName]);

        if(! $permission){
            $response["success"] = false;
            $response["message"] = "No permission created";
        } else {
            $response["success"] = true;
            $response["message"] = "Permission created successfully";
            $response["data"] = $permission;
        }

        return $response;
    }

    public function update($id, Request $request){
        $permission = Permissions::find($id);

        if($permission->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Permission not found";
        } else {
            $permission->name = $request->permissionName;
            $permission->save();
            $response["success"] = true;
            $response["message"] = "Permission updated successfully";
            $response["data"] = $permission;
        }

        return $response;
    }

    public function assignPermissionsToRole($id, Request $request){
        $role = Role::find($id);

        if($role->isEmpty()){
            $response["success"] = false;
            $response["message"] = "Role not found";
        } else {
            foreach($request->permissions as $permission){
                $role->givePermissionTo($permission);
            }
            $response["success"] = true;
            $response["message"] = "Permissions assigned to role successfully";
            $response["data"] = $role;
        }

        return $response;
    }

    public function revokePermissionsFromRole($id, Request $request){
        $role = Role::find($id);

        if($role->isEmpty()){
            $response["sucess"] = false;
            $response["message"] = "Role not found";
        } else {
            foreach($request->permissions as $permission){
                $role->revokePermissionTo($permission);
            }
            $response["success"] = true;
            $response["message"] = "Permissions revoked from role successfully";
            $response["data"] = $role;
        }

        return $response;
    }
}
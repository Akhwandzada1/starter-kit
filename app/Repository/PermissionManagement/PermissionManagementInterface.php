<?php

namespace App\Repository\PermissionManagement;
use Illuminate\Http\Request;

interface PermissionManagementInterface {
    //This method will get all the permissions with functionality to filter permissions based on their name
    public function index(Request $request);
    
    //This method will be used to delete the permission
    //@param: id of the permission which we want to delete.
    public function destroy($id);

    //This method will be used to create new permission.
    public function createPermission(Request $request);

    //This method will be used to update the name of the permission.
    //@param: id of the role which we want to update
    public function update($id, Request $request);

    //This method will be used to assign permission to the role.
    //@param: id of the role which we want to assign permission.
    //Here request will contain the array of permission id'd which we want to add for a role.
    public function assignPermissionsToRole($id, Request $request);

    //This method will be used to revoke permission from a role.
    //@param: id of the role from which we want to revoke permission.
    //Here request will contain the array of permission id's which we want to revoke.
    public function revokePermissionsFromRole($id, Request $request);

}

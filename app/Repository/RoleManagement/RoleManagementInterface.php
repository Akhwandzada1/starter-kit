<?php

namespace App\Repository\RoleManagement;
use Illuminate\Http\Request;

interface RoleManagementInterface {
    
    //This method will be used to show all the roles.
    public function index(Request $request);

    //This method will be used to create new roles
    public function store(Request $request);

    //This method will be used to update the role
    //@param: id of the role which we want to update.
    public function update($id, Request $request);

    //This method will be used to delete the role.
    //@param: id of the role which we want to delete.
    public function destroy($id);

    //This method will assign role to the user.
    //@param: userId will be the id of the user to which we want to assign Role.
    //@param: roleId will be the id of the role which we want to assign.
    public function assignRoleToUser($userId, $roleId);

    //This method will be used to remove role from the user.
    //@param: userId will be the id of the user for which we will revoke the Role.
    //@param: roleId will be the id of the role which we want to revoke.
    public function revokeRoleFromUser($userId, $roleId);

}
<?php

namespace App\Repository\UserManagement;

use Illuminate\Http\Request;

interface UserManagementInterface {

    //This method will be used to retrieve all the users in the system
    public function index(Request $request);

    //This method will be used to create new user in the system
    public function store(Request $request);

    //This method will be used to update the user
    //@param: id of the user which we want to update.
    public function update($id, Request $request);

    //This method will be used to delete the user
    //@param: id of the user which we want to delete.
    public function destroy($id);
}

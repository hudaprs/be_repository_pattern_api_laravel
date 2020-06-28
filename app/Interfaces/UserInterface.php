<?php

namespace App\Interfaces;

use App\Http\Requests\UserRequest;

interface UserInterface
{
    /**
     * Get all users
     * 
     * @method  GET api/users
     * @access  public
     */
    public function getAllUsers();

    /**
     * Get User By ID
     * 
     * @param   integer     $id
     * 
     * @method  GET api/users/{id}
     * @access  public
     */
    public function getUserById($id);

    /**
     * Create | Update user
     * 
     * @param   \App\Http\Requests\UserRequest    $request
     * @param   integer                           $id
     * 
     * @method  POST    api/users       For Create
     * @method  PUT     api/users/{id}  For Update     
     * @access  public
     */
    public function requestUser(UserRequest $request, $id = null);

    /**
     * Delete user
     * 
     * @param   integer     $id
     * 
     * @method  DELETE  api/users/{id}
     * @access  public
     */
    public function deleteUser($id);
}
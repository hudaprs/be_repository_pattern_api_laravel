<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

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
     * @param   \Illuminate\Http\Request    $request
     * @param   integer                     $id
     * 
     * @method  POST    api/users       For Create
     * @method  PUT     api/users/{id}  For Update     
     * @access  public
     */
    public function requestUser(Request $request, $id);

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
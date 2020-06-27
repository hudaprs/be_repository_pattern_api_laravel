<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'message' => 'Users',
            'code' => 200,
            'error' => false,
            'results' =>  User::orderBy('name', 'asc')->get()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the forms
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|max:50'
        ]);

        DB::beginTransaction();   
        try {
            $newUser = new User;
            $newUser->name = $request->name;
            $newUser->email = preg_replace('/\s+/', '', strtolower($request->email));
            $newUser->password = \Hash::make($request->password);
            $newUser->save();

            DB::commit();
            return response()->json([
                'message' => 'User created',
                'code' => 200,
                'error' => false,
                'results' => $newUser
            ], 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
                'code' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        // Check user
        if(!$user) return response()->json(['message' => 'No user found'], 404);

        return response()->json([
            'message' => 'User detail',
            'code' => 200,
            'error' => false,
            'results' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the forms
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users,email,' . $id
        ]);

        DB::beginTransaction();
        try {
            $user = User::find($id);

            // Check user
            if(!$user) return response()->json(['message' => 'No user found'], 404);

            // Update
            $user->name = $request->name;
            $user->email = preg_replace('/\s+/', '', strtolower($request->email));
            $user->save();

            DB::commit();
            return response()->json([
                'message' => 'User updated',
                'code' => 200,
                'error' => false,
                'results' => $user
            ], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
                'code' => 500
            ], 500);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $user = User::find($id);

            // Check user
            if(!$user) return response()->json(['message' => 'No user found'], 404);

            // Delete user
            $user->delete();

            DB::commit();
            return response()->json([
                'message' => 'User deleted',
                'code' => 200,
                'error' => false,
                'results' => $user
            ], 200);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage(),
                'error' => true,
                'code' => 500
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     /* @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return User::all();
        
        $users = User::paginate(10);
        
        // Return collection of posts as a resource
        return UserResource::collection($users);
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->avatar = $request->avatar;
        $user->pseudo = $request->pseudo;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get a single user
        $user = User::findOrFail($id);
        
        // Return a single user as a resource
        return new UserResource($user);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get the user
        $user = User::findOrFail($id);
        
        //  Delete the user, return as confirmation
        if ($user->delete()) {
            return new UserResource($user);
        }
    }
}

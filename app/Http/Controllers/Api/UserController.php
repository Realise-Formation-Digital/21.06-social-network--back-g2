<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Like;
use App\Models\Abbonement;
use App\Services\UserService;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    private $userService;

    /**
     * Display a listing of the resource.
     */
     /* @return \Illuminate\Http\Response

     */
public function __construct(UserService $userService) {
    $this->userService = $userService;
}


    public function index()
    {
        //return User::all();
        $users = $this->userService->allUser();
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
        //Add new User
        /*
        $users = $this->userService->addUser();
        return new UserResource($user);
        */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->userService->getUser($id);
        return new UserResource($user);
        // Get a single user
        /*
        $user = User::findOrFail($id);
        $user->posts;
        */

        // Return a single user as a resource

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
        /*
        $user = $this->userService->modifUser($id);
        return new UserResource($user);
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = $this->userService->delUser($id);
        return new UserResource($user);
    }
}

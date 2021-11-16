<?php
namespace App\Services;

use App\Transaction;
use App\Models\User;
use Carbon\Carbon;
use App\Http\Controllers\Api\UserController;

class UserService {

    public static function getUser($id)
    { 
        // Get a single user
        $user = User::findOrFail($id);
        $user->posts;
        
        // Return a single user as a resource
        return $user;
        
        //return User::all();
    }
    public static function allUser()
    { 
        $users = User::paginate(10);
        return $users;
        // Return collection of posts as a resource
        
    
    }
}
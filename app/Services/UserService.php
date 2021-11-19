<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

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

    public static function addUser(Request $request)
    {
        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->avatar = $request->avatar;
        $user->pseudo = $request->pseudo;
        $user->password = $request->password;
        $user->email = $request->email;
        $user->save();
        return $user;
        // Return collection of posts as a resource


    }
    public static function modifUser(Request $request, $id){
        try {
            //search user id and verify modification
            $user = User::find($id);
            $user->avatar = $request->avatar ? $request->avatar : $user->avatar;
            $user->pseudo = $request->pseudo ? $request->pseudo : $user->pseudo;
            $user->email = $request->email ? $request->email : $user->email;
            $user->password = $request->password ? $request->password : $user->password;

            /*
            if ($request->avatar) {
                $user->avatar = $request->avatar;
            } else {
                $user->avatar = $user->avatar;
            }
            */

            $user->save();
            return response()->json([
                'status_code' => 200,
                'message' => "L'utilisateur a été modifié",
                'data' => $user
            ]);
            // $user->update($request->all());
        }
        catch(\Exception $e) {
            return response()->json([
                'status_code' => 400,
                'message' => "Il y a eu une erreur lors de la modification de l'utilisateur"
            ]);
        }
    }
    public static function delUser($id){
        // Get the user
        $user = User::findOrFail($id);

        //  Delete the user, return as confirmation
        if ($user->delete()) {
            return $user;
        }
    }
}

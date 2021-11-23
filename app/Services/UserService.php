<?php
namespace App\Services;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Exceptions\ApiException;

class UserService {

    private $validatorService;

    public function __construct(ValidatorService $validatorService) {
        $this->validatorService = $validatorService;
    }

    public function getUser($id)
    {
        // Get a single user
        $user = User::findOrFail($id);
        $user->posts;

        // Return a single user as a resource
        return $user;

        //return User::all();
    }
    public function allUser()
    {
        $users = User::paginate(10);
        return $users;
        // Return collection of posts as a resource


    }

    public function addUser(Request $request)
    {
        try {
            // Etape 1: Valider les champs
            $this->validatorService->validateFields($request->all(), $this->validateUser());

            // Etape 2: Créer le user
            $user = new User;
            $user->first_name = $request->input('first_name');
            $user->last_name = $request->input('last_name');
            $user->avatar = $request->input('avatar');
            $user->pseudo = $request->input('pseudo');
            $user->password = bcrypt('test1234');
            $user->email = $request->input('email');
            $user->save();

            // Etape 3: Retourner le user
            return $user;

        } catch(Exception $e) {
            throw new ApiException("Il y a eu une erreur lors de la création de l'utilisateur");
        }

    }
    public function modifUser(Request $request, $id){
        try {
            // Etape 1: Valider les champs
            $this->validatorService->validateFields($request->all(), $this->validateUser());

            // Etape 2: Modifier le user
            $user = User::find($id);
            $user->avatar = $request->input('avatar') ? $request->input('avatar') : $user->avatar;
            $user->pseudo = $request->input('pseudo') ? $request->input('pseudo') : $user->pseudo;
            $user->email = $request->input('email') ? $request->input('email') : $user->email;
            $user->password = $request->input('password') ? $request->input('password') : $user->password;

            /*
            if ($request->avatar) {
                $user->avatar = $request->avatar;
            } else {
                $user->avatar = $user->avatar;
            }
            */

            $user->save();
            return $user;
            // $user->update($request->all());
        }
        catch(Exception $e) {
            throw new ApiException("Il y a eu une erreur lors de la modification de l'utilisateur");
        }
    }
    public function delUser($id){
        try{

            // Get the user
            $user = User::where('id',$id)->delete();


            //  Delete the user, return as confirmation
            return $user;
        }
         catch(Exception $e) {
            throw new ApiException("Il y a eu un problème lors de la suppression de l'utilisateur");
        }
    }


    //Validation fields user
    /**
     *
     * @param  bool $update
     * @return array
     */
    public function validateUser()
    {
      // Validating fields.
      $validatorRules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'pseudo' => 'required|string|unique:users,pseudo',
        'avatar' => 'required|string|max:255',
        'email' => 'required|string|email|unique:users,email'
      ];

      return $validatorRules;
    }

}

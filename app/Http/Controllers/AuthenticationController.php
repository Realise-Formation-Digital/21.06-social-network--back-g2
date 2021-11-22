<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    /**
     * This method adds new users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
   */

    /**
     * Use this method to signin users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function createAccount(Request $request)
    {
        $attr = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'pseudo' => 'required|string|unique:users,pseudo',
            'avatar' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6'
        ]);

        $user = User::create([
            'first_name' => $attr['first_name'],
            'last_name' => $attr['last_name'],
            'avatar' => $attr['avatar'],
            'pseudo' => $attr['pseudo'],
            'email' => $attr['email'],
            'password' => bcrypt($attr['password'])

        ]);

        return $this->success([
            'token' => $user->createToken('tokens')->plainTextToken
        ]);
    }
    public function signin(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken
        ]);
    }

    /**
     * This method signs out users by removing tokens.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */

    public function signout()
    {
        auth()->user()->tokens()->delete();

        return $this->success([
            'message' => 'Tokens Revoked'
        ]);
    }

    /**
     * Return a formated JSON response.
     *
     * @param string $body
     * @return \Illuminate\Http\Response
     */

    private function success($body) {
        return response()->json($body);
    }

    /**
     * Return a formated JSON response.
     *
     * @param string $message
     * @param string $status
     * @return \Illuminate\Http\Response
     */

    private function error($message, $status) {
        return response()->json([
            'status_code' => $status,
            'message' => $message
        ]);
    }



    //Validation fields posts
    /**
     *
     * @param  bool $update
     * @return array
     */
    public function validateUser($update = false)
    {
      // Validating fields.
      $validatorRules = [
      'title' => 'required|string|max:128',
      'content' => 'required|string|max:128',
      'img' => 'required|string|max:128',
      'date' => 'required|date',
      ];

      // Check id when account is updated.
      if ($update) {
        $validatorRules['id'] = 'required|integer|digits_between:1,20';
      }
      return $validatorRules;
    }

}

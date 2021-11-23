<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\ValidatorService;

class AuthenticationController extends Controller
{
    private $validatorService;

    public function __construct(ValidatorService $validatorService) {
        $this->validatorService = $validatorService;
    }

    /**
     * This method adds new users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createAccount(Request $request)
    {
        $attr = $this->validatorService->validateFields($request->all(), [
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

    /**
     * Use this method to signin users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signin(Request $request)
    {
        $attr = $this->validatorService->validateFields($request->all(), [
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

}

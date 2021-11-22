<?php

namespace App\Http\Controllers\Api;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Mail\Contact;
use App\Models\User;

class ContactController extends Controller
{
    public function contactPost(Request $request)
    {

        $body = [
            'nom' => 'Mail from ItSolutionStuff.com',
            'email' => 'This is for testing email using smtp',
            'message' => 'This is for testing email using smtp'

        ];

        $user = Auth::user();
        $email = $user->email;
        $emailToSend = new \App\Mail\Contact($body);
        Mail::to($email)->send($emailToSend);

        return response()->json([
            'status_code' => 200,
            'message' => "Votre e-mail a bien été envoyé"
        ]);
    }
}

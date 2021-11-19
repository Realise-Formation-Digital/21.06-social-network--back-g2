<?php

namespace App\Http\Controllers\Api;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ContactController extends Controller
{
    public function contactPost(Request $request)
    {

        $details = [
            'nom' => 'Mail from ItSolutionStuff.com',
            'email' => 'This is for testing email using smtp',
            'message' => 'This is for testing email using smtp'

        ];

        Mail::to('maverickhegi@gmail.com')->send(new \App\Mail\Contact($details));

        dd("Email is Sent.");

        return view('confirm');
    }
}

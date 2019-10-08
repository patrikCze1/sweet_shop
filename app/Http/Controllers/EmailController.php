<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendContact;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function contact(Request $request)
    {
        $request->validate([
            'mail' => 'required',
            'text' => 'required',
        ]);

        // adresa

        Mail::to('test@seznam.cz')->send(new SendContact($request->mail, $request->text));

        return redirect('/kontakt')->with('success', 'Email odeslán');
    }
}

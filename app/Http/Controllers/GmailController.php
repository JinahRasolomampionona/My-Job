<?php

namespace App\Http\Controllers;

use App\Mail\GmailEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class GmailController extends Controller
{
    //
    public function send(Request $request): void
    {
        Mail::to($request->user())->send(new GmailEmail);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
   public function home() {
    // $offres = Offers::where('status', 'validee')->get();
    $offresUrgentes = Offers::where('status', 'validee')
                        ->get();
                       
    return view('index', ['offresView' => $offresUrgentes]);
    
   }
   
}

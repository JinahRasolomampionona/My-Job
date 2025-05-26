<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //
    public function index(Request $request) {
        $input = $request->validate([
            'titre'=>'required|string',
            'localisation'=>'nullable|string'
        ]);
        $offres = Offers::query()
        ->when(isset($input['localisation']), function($query) use ($input) {
            $query->where('localisation', 'like', "%{$input['localisation']}%");
        }) 
        ->where(function($query) use ($input) {
            $query->where('titre', 'like', "%{$input['titre']}%")
            ->orWhere('entreprise', 'like', "%{$input['titre']}%");
        })
        ->get();
        // dd($offres);
        return view('search.index', ['offres'=>$offres, 'input'=>$input]);
    }
    
}

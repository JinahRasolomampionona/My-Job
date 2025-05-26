<?php

namespace App\Http\Controllers;

use App\Models\Offers;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offres = Offers::all();
        return view('offers.index', ['offresView' => $offres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('offers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $offres = new Offers();
        $offres->titre = $request->input('titre');
        $offres->entreprise = $request->input('entreprise');
        $offres->contrat = $request->input('contrat');
        $offres->localisation = $request->input('localisation');
        $offres->domaine = $request->input('domaine');
        $offres->description = $request->input('description');
        $offres->save();
        // Mail::to($request->user())->send(new GmailEmail);
        return redirect()->route('offers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $offres = Offers::find($id);
        return view('offers.show', ['offresView' => $offres]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $offres = Offers::find($id);
        return view('offers.edit', ['offresView' => $offres]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $offres = Offers::find($id);
        $offres->titre = $request->input('titre');
        $offres->entreprise = $request->input('entreprise');
        $offres->contrat = $request->input('contrat');
        $offres->localisation = $request->input('localisation');
        $offres->domaine = $request->input('domaine');
        $offres->description = $request->input('description');
        $offres->save();
        return redirect()->route('offers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $offres = Offers::find($id);
        $offres ->destroy($offres->id);
        return redirect()->route('offers.index');
    }
}

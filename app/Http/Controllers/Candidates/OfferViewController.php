<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;

class OfferViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $offres = Offres::all();
        $offres = Offers::where('status', 'validee')->get();
        return view('candidates.offers.index', ['offresView' => $offres]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Offers $offre)
    {
        //
        return view('candidates.offers.show', ['offresView' => $offre]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

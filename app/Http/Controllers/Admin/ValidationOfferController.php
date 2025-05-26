<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;

class ValidationOfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $offre = Offers::where('status', 'en attente')->get();
        return view('admin.offers.index', ['offresView' => $offre]);
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
        return view('admin.offers.show', ['offresView' => $offre]);
    }

    public function valider(Offers $offre)
    {
        $offre->status = 'validee';
        $offre->save();

        return redirect()->back()->with('message', 'Offre validée');
    }

    public function refuser(Offers $offre)
    {
        $offre->status = 'refusee';
        $offre->save();

        return redirect()->back()->with('message', 'Offre refusée');
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

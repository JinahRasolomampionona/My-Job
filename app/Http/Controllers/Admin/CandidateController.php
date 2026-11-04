<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidats = User::where('role', 'candidat')->latest()->get();
        return view('admin.candidates', ['users' => $candidats]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Movement;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * DocumentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //Documents download US.25
    public function download($document)
    {
        //
    }

    //Destroy document US.24
    public function destroy($document)
    {
        //
    }

    //Store document US.23
    public function create(Movement $movement)
    {
        return view('movements.document.add', compact('movement'));
    }

    public function store(Request $request, $movement)
    {
        //
    }
}

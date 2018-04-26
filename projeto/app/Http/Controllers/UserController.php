<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // US.1
    public function index()
    {
        //
    }

    // Formulário para registar US.2
    public function create()
    {
        //
    }
    // Acção de registar
    public function store(Request $request)
    {
        //
    }

    //render login
    public function renderLogin()
    {
        //
    }

    //submissao login (US.3)
    public function login(Request $request)
    {
        //
    }

    //render password
    public function renderPassword()
    {
        //
    }

    //submissao password (US.9)
    public function password(Request $request)
    {
        //
    }

    //Dashboard US.26
    public function dashboard()
    {
        //
    }

    //storeAssociate US.29
    public function storeAssociate(Request $request)
    {
        //
    }

    //destroyAssociate US.30
    public function destroyAssociate($user)
    {
        //
    }
}

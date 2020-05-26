<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Http\Request;

class RegisterMahasiswaController extends RegisterController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showRegistrationForm()
    {
        return view('register.mahasiswa');
    }



}

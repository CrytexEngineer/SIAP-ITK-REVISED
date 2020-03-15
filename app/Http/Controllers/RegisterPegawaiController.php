<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegisterPegawaiController extends Controller
{
    public function showRegistrationForm()
{
    return view('register.pegawai');
}
}

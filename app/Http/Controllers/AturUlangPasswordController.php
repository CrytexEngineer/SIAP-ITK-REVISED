<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AturUlangPasswordController extends Controller
{
    public function index()
    {
        return view('reset_password');
    }
}

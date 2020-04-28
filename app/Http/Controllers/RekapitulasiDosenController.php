<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RekapitulasiDosenController extends Controller
{
    public function index()
    {
        return view('rekapitulasi.dosen.index');
    }
}

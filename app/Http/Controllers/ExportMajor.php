<?php

namespace App\Http\Controllers;

use App\Exports\MajorExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportMajor extends Controller
{
    public function export()
    {
        return Excel::download(new MajorExport, 'Rekapitulasi.xlsx');
    }
}

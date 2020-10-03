<?php

namespace App\Http\Controllers;

use App\Exports\LectureByMajorExport;
use App\Exports\LectureBySubjectExport;
use App\Exports\StudentByMajorSheet;
use App\Exports\StudentBySubjectExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportMajor extends Controller
{
    public function export()
    {
        return Excel::download(new LectureBySubjectExport("SF1226"), 'Rekapitulasi.xlsx');
    }
}

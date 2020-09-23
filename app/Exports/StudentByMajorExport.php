<?php

namespace App\Exports;


use App\Major;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentByMajorExport implements WithMultipleSheets
{


    /**
     * StudentReportExport constructor.
     */
    private $PS_Kode_Prodi;

    public function __construct($PS_Kode_Prodi)
    {
        $this->PS_Kode_Prodi = $PS_Kode_Prodi;
    }

    /**
     * @inheritDoc
     */
    public function sheets(): array
    {
        $sheets = [];
        $PS_Kode_Prodi = $this->PS_Kode_Prodi;
        if ($PS_Kode_Prodi == 0000 || $PS_Kode_Prodi == null) {
            $PS_Kode_Prodi = Major::all();
            foreach ($PS_Kode_Prodi as $prodi) {
                $sheets[] = new StudentByMajorSheet($prodi->PS_Kode_Prodi);
            }
        } else {

            $sheets[] = new StudentByMajorSheet($PS_Kode_Prodi);

        }

        return $sheets;
    }
}

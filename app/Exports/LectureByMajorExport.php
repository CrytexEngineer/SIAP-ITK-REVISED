<?php


namespace App\Exports;


use App\Major;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LectureByMajorExport implements WithMultipleSheets
{

    /**
     * @inheritDoc
     */

    private $PS_Kode_Prodi;

    public function __construct($PS_Kode_Prodi)
    {
        $this->PS_Kode_Prodi = $PS_Kode_Prodi;
    }



    public function sheets(): array
    {
        $sheets = [];
        $PS_Kode_Prodi = $this->PS_Kode_Prodi;
        if ($PS_Kode_Prodi == 0000 || $PS_Kode_Prodi == null) {
            $sheets = [];
            $PS_Kode_Prodi=Major::all();
            foreach ($PS_Kode_Prodi as $prodi) {
                $sheets[] = new LectureByMajorSheet($prodi->PS_Kode_Prodi);
            }

        } else {
            $sheets[] = new LectureByMajorSheet($PS_Kode_Prodi);
        }

        return $sheets;
    }
}

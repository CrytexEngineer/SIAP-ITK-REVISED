<?php


namespace App\Exports;


use App\Kelas;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentBySubjectExport implements WithMultipleSheets
{

    private $MK_ID;

    public function __construct($MK_ID)
    {
        $this->MK_ID = $MK_ID;
    }


    public function sheets(): array
    {
        $sheets[] = new StudentBySubjectSheet($this->MK_ID);
        return $sheets;
    }


    /**
     * @inheritDoc
     */
//    public function sheets(): array
//    {
//        $sheets = [];
//        $Kelas = Kelas::where("KE_KodeJurusan", "=", $this->PS_Kode_Prodi)->get();
//        foreach ($Kelas as $matakuliah) {
//            $sheets[] = new StudentBySubjectSheet($matakuliah->KE_KR_MK_ID);
//
//        }
//        return $sheets;
//    }
}

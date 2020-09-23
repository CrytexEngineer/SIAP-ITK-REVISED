<?php


namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LectureBySubjectExport implements WithMultipleSheets
{

    private $MK_ID;

    public function __construct($MK_ID)
    {
        $this->MK_ID = $MK_ID;

    }

    public function sheets(): array
    {

        $sheets[] = new LectureBySubjectSheet($this->MK_ID);
           return $sheets;
    }



    /**
     * @inheritDoc
     */
//    public function sheets(): array
//    {
//        $sheets = [];
//        $Kelas = Kelas::where("KE_KodeJurusan", "=", $this->PS_Kode_Prodi)->get();
//
//            $sheets[] = new LectureBySubjectSheet($Kelas[0]->KE_KR_MK_ID);
//
//
//        return $sheets;
//    }
}

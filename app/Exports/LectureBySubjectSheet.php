<?php

namespace App\Exports;

use App\Curiculum;
use App\Major;
use App\Meeting;
use App\Subject;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class LectureBySubjectSheet implements  WithEvents, WithStrictNullComparison, ShouldAutoSize, WithCustomStartCell, WithTitle
{

    use Exportable, RegistersEventListeners;

    private $MK_ID;
    private $MK_Mata_Kuliah;
    private $week;


    public function __construct($MK_ID)
    {

        $this->MK_ID = $MK_ID;
        $this->MK_Mata_Kuliah = Subject::where('MK_ID', '=', $MK_ID)->get()->first()->MK_Mata_Kuliah;
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $dateCuriculum = new DateTime(Curiculum::all()->sortByDesc('KL_Date_Start')->first()->KL_Date_Start);
        $now = new DateTime();
        $this->week = round(date_diff($dateCuriculum, $now)->days / 7);


    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {
                //Inisiasi Variabel Umum
                $data = Meeting::count(['KE_KR_MK_ID' => $this->MK_ID]);
                $sheet = $event->sheet->getDelegate();
                $row = 12;
                $startRow = -1;
                $endRow = $sheet->getHighestRow();
                $previousKey = '';
                $columnNumber = 1;
                $studentNumber = 1;


                // Merge Cell
                foreach ($data as $index => $value) {
                    $sheet->setCellValue('B' . $row, $value->PE_NamaLengkap);
                    $sheet->setCellValue('C' . $row, $value->tim_dosen);
                    $sheet->setCellValue('D' . $row, $value->KE_KR_MK_ID);
                    $sheet->setCellValue('E' . $row, $value->MK_Mata_Kuliah);
                    $sheet->setCellValue('F' . $row, $value->MK_KreditKuliah);
                    $sheet->setCellValue('G' . $row, $value->KE_Kelas);
                    $sheet->setCellValue('H' . $row, $value->KE_Terisi);
                    $sheet->setCellValue('I' . $row, $value->KE_RencanaTatapMuka);
                    $sheet->setCellValue('J' . $row, $value->KE_RealisasiTatapMuka);
                    $sheet->setCellValue('K' . $row, $value->KE_isLate);
                    $sheet->setCellValue('L' . $row, ($value->KE_Prosentase/100));


                    if ($startRow == -1) {
                        $startRow = $row;
                        try {
                            //Dosen
                            $previousKey = $value->PE_NamaLengkap;


                        } catch (Exception $e) {
                            dd($e);
                        }

                    }

                    try {
                        //Dosen
                        $nextKey = isset($data[$index + 1]) ? $data[$index + 1]->PE_NamaLengkap : null;


                    } catch (Exception $e) {
                        dd($e);
                    }
                    if ($row >= $startRow && (($previousKey <> $nextKey) || ($nextKey == null))) {

                        $sheet->setCellValue('A' . $row, $columnNumber);
                        $columnNumber++;
                        $cellToMerge = [
                            "A" . ($startRow) . ":A" . $row,
                            "B" . ($startRow) . ":B" . $row,
                            "C" . ($startRow) . ":C" . $row,


                        ];

                        try {
                            foreach ($cellToMerge as $rage) {
                                $sheet->getStyle($rage)->getAlignment()->setVertical('center');
                                $sheet->mergeCells($rage);

                            }

                        } catch (Exception $e) {
                            dd($e);
                        }
                        $startRow = -1;
                    } else {
                        $sheet->setCellValue('A' . $row, $columnNumber);


                    }


                    $row++;

                }


                //Membuat Baris Tanda Tangan

                $sheet->setCellValue('I' . ($row + 3), "Balikpapan," . $this->tgl_indo(Carbon::now()->format('Y-m-d')));
                $sheet->setCellValue('I' . ($row + 4), "Kasubbag Akademik dan Kemahasiwaan");
                $sheet->setCellValue('I' . ($row + 9), "Nama Lengkap");
                $sheet->setCellValue('I' . ($row + 10), "NIP");
                $sheet->getStyle('I'.$row.':I'.($row+10))->getFont()->setName('Times New Roman');

                //Membuat Header
                $sheet->getStyle("A11:F" . 11)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->setAutoFilter('A11:L' . $row);
                $sheet->getStyle('A11:N11')->getFont()->setBold('true');
                $sheet->setCellValue('A11', "NO");
                $sheet->setCellValue('B11', "NAMA DOSEN");
                $sheet->setCellValue('C11', "TIM PENGAJAR");
                $sheet->setCellValue('D11', "KODE MATA KULIAH");
                $sheet->setCellValue('E11', "MATA KULIAH");
                $sheet->setCellValue('F11', "SKS");
                $sheet->setCellValue('G11', "KELAS");
                $sheet->setCellValue('H11', "JUMLAH PESERTA");
                $sheet->setCellValue('I11', "JUMLAH TATAP MUKA");
                $sheet->setCellValue('J11', "KEHADIRAN");
                $sheet->setCellValue('K11', "DI LUAR JADWAL");
                $sheet->setCellValue('L11', "PROSENTASE");

                //Formatting Table
                $sheet->getStyle('A1:L' . $row)->getFont()->setName('Times New Roman');
                $sheet->getStyle('B11:L' . $row)->getAlignment()->setWrapText(true);
                $sheet->getStyle("A12:A" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D12:D" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("F12:L" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getColumnDimension("A")->setWidth(6);
                $sheet->getColumnDimension("B")->setWidth(40);
                $sheet->getColumnDimension("C")->setWidth(40);
                $sheet->getColumnDimension("D")->setWidth(11);
                $sheet->getColumnDimension("E")->setWidth(38);
                $sheet->getColumnDimension("H")->setWidth(12);
                $sheet->getColumnDimension("I")->setWidth(9);
                $sheet->getColumnDimension("J")->setWidth(9);
                $sheet->getColumnDimension("K")->setWidth(9);
                $sheet->getColumnDimension("L")->setWidth(9);
//                $sheet->getColumnDimension("J")->setAutoSize(true);

//                $sheet->getColumnDimension("A")->setAutoSize(true);
//                $sheet->getColumnDimension("B")->setAutoSize(true);
//                $sheet->getColumnDimension("C")->setAutoSize(true);


                try {
                    $sheet->getStyle('A11:L' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                } catch (Exception $e) {
                    dd($e);
                }
                $sheet->getStyle("L11:L" . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE);


                //Membuat Kepala Surat

                for ($row = 1; $row <= 10; $row++) {
                    try {
                        $sheet->mergeCells('A' . $row . ":L" . $row);
                    } catch (Exception $e) {
                    }
                    $sheet->getStyle('A' . $row . ":L" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $sheet->setCellValue('A1', "KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN");
                $sheet->setCellValue('A2', "INSTITUT TEKNOLOGI KALIMANTAN");
                $sheet->setCellValue('A3', "Kampus ITK Karang Joang, Balikpapan 76127");
                $sheet->setCellValue('A4', "Telepon (0542) 8530801 Faksimile (0542) 8530800N");
                $sheet->setCellValue('A5', "Surat elektronik : humas@itk.ac.id  laman : www.itk.ac.id");
                $sheet->setCellValue('A7', "REKAPITULASI MONITORING KEHADIRAN MENGAJAR DOSEN SAMPAI DENGAN MINGGU KE " . $this->week);
                $sheet->setCellValue('A8', "MATA KULIAH " . strtoupper($this->MK_Mata_Kuliah));
                $sheet->setCellValue('A9', "TAHUN AKADEMIK " . strtoupper(Curiculum::all()->sortByDesc('KL_Date_Start')->first()->KL_Tahun_Kurikulum));

                $sheet->getStyle('A1')->getFont()->setSize('14');
                $sheet->getStyle('A2')->getFont()->setSize('14');
                $sheet->getStyle('A2')->getFont()->setBold('true');
                $sheet->getStyle('A3:A5')->getFont()->setSize('12');
                $sheet->getStyle('A6:L6')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
                $sheet->getStyle('A7:A9')->getFont()->setSize('14');

                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                try {
                    $drawing->setPath('img/itk_logo.jpg');
                } catch (Exception $e) {
                }
                $drawing->setHeight(36);
                try {
                    $drawing->setWorksheet($sheet);
                } catch (Exception $e) {
                }
                $drawing->setWidth(97);
                $drawing->setCoordinates('B1');


            },
        ];
    }


    /**
     * @inheritDoc
     */
    public function startCell(): string
    {
        return "B12";
    }

    /**
     * @inheritDoc
     */
    public function title(): string
    {
        return $this->MK_Mata_Kuliah;
    }

    public function tgl_indo($tanggal)
    {
        $bulan = array(
            1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('-', $tanggal);

        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
    }

    /**
     * @inheritDoc
     */

}

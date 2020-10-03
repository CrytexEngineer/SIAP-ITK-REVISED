<?php

namespace App\Exports;

use App\Curiculum;
use App\Major;
use App\Presence;
use Carbon\Carbon;
use DateTime;
use Maatwebsite\Excel\Concerns\Exportable;
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


class StudentByMajorSheet implements WithEvents, WithStrictNullComparison, ShouldAutoSize, WithCustomStartCell, WithTitle
{

    use Exportable, RegistersEventListeners;

    private $PS_Kode_Prodi;
    private $PS_Nama;
    private $week;


    public function __construct($PS_Kode_Prodi)
    {
        $this->PS_Kode_Prodi = $PS_Kode_Prodi;
        $this->PS_Nama = Major::where('PS_Kode_Prodi', '=', $PS_Kode_Prodi)->get()->first()->PS_Nama;
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
                $data = Presence::countBySubject(['KE_KodeJurusan' => $this->PS_Kode_Prodi]);
                $sheet = $event->sheet->getDelegate();
                $row = 12;
                $startRow = -1;
                $endRow = $sheet->getHighestRow();
                $previousKey = '';
                $columnNumber = 1;
                $studentNumber = 1;


                // Merge Cell
                foreach ($data as $index => $value) {

                    $sheet->setCellValue('B' . $row, $value->KU_KE_KR_MK_ID);
                    $sheet->setCellValue('C' . $row, $value->MK_Mata_Kuliah);
                    $sheet->setCellValue('D' . $row, $value->MK_KreditKuliah);
                    $sheet->setCellValue('E' . $row, $value->KU_KE_Kelas);
                    $sheet->setCellValue('F' . $row, $value->PE_NamaLengkap);
                    $sheet->setCellValue('G' . $row, $value->KE_Terisi);
                    $sheet->setCellValue('I' . $row, $value->MA_NRP_Baru);
                    $sheet->setCellValue('J' . $row, $value->MA_NamaLengkap);
                    $sheet->setCellValue('K' . $row, $value->pekan_perkuliahan);
                    $sheet->setCellValue('L' . $row, $value->Jumlah_Pertemuan);
                    $sheet->setCellValue('M' . $row, $value->Kehadiran);
                    $sheet->setCellValue('N' . $row, $value->persentase / 100);


                    if ($startRow == -1) {
                        $startRow = $row;
                        try {
                            //Matakuliah
                            $previousKey = $value->MK_Mata_Kuliah;
                            //Kelas
                            $previousKey2 = $value->KU_KE_Kelas;
                        } catch (Exception $e) {
                            dd($e);
                        }

                    }

                    try {
                        //matakuliah
                        $nextKey = isset($data[$index + 1]) ? $data[$index + 1]->MK_Mata_Kuliah : null;

                        //Kelas
                        $nextKey2 = isset($data[$index + 1]) ? $data[$index + 1]->KU_KE_Kelas : null;
                    } catch (Exception $e) {
                        dd($e);
                    }
                    if ($row >= $startRow && (($previousKey <> $nextKey) || ($nextKey == null))) {

                        $sheet->setCellValue('A' . $row, $columnNumber);
                        $columnNumber++;
                        $sheet->setCellValue('H' . $row, $studentNumber);
                        $studentNumber = 1;
                        $cellToMerge = [
                            "A" . ($startRow) . ":A" . $row,
                            "B" . ($startRow) . ":B" . $row,
                            "C" . ($startRow) . ":C" . $row,
                            "D" . ($startRow) . ":D" . $row,
                            "E" . ($startRow) . ":E" . $row,
                            "F" . ($startRow) . ":F" . $row,
                            "G" . ($startRow) . ":G" . $row,
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

                        if ($row >= $startRow && (($previousKey2 <> $nextKey2) || ($nextKey == null))) {
                            $sheet->setCellValue('H' . $row, $studentNumber);
                            $studentNumber = 1;
                            $cellToMerge = [
                                "A" . ($startRow) . ":A" . $row,
                                "B" . ($startRow) . ":B" . $row,
                                "C" . ($startRow) . ":C" . $row,
                                "D" . ($startRow) . ":D" . $row,
                                "E" . ($startRow) . ":E" . $row,
                                "F" . ($startRow) . ":F" . $row,
                                "G" . ($startRow) . ":G" . $row,
                            ];
//
                            try {
                                foreach ($cellToMerge as $rage) {
                                    $sheet->getStyle($rage)->getAlignment()->setVertical('center');
                                    $sheet->mergeCells($rage);

                                }

                            } catch (Exception $e) {
                                dd($e);
                            }
                            $columnNumber++;
                            $startRow = -1;


                        } else {
                            $sheet->setCellValue('H' . $row, $studentNumber);
                            $sheet->setCellValue('A' . $row, $columnNumber);
                            $studentNumber++;
                        }

                    }

                    $row++;

                }


                //Membuat Baris Tanda Tangan

                $sheet->setCellValue('K' . ($row + 3), "Balikpapan," . $this->tgl_indo(Carbon::now()->format('Y-m-d')));
                $sheet->setCellValue('K' . ($row + 4), "Kasubbag Akademik dan Kemahasiwaan");
                $sheet->setCellValue('K' . ($row + 9), "Nama Lengkap");
                $sheet->setCellValue('K' . ($row + 10), "NIP");
                $sheet->getStyle('K'.$row.':K'.($row+10))->getFont()->setName('Times New Roman');

                //Membuat Header
                $sheet->setAutoFilter('A11:N' . $row);
                $sheet->getStyle('A11:N11')->getFont()->setBold('true');
                $sheet->setCellValue('A11', "NO");
                $sheet->setCellValue('B11', "KODE MATA KULIAH");
                $sheet->setCellValue('C11', "MATA KULIAH");
                $sheet->setCellValue('D11', "SKS");
                $sheet->setCellValue('E11', "KELAS");
                $sheet->setCellValue('F11', "DOSEN PENGAMPU");
                $sheet->setCellValue('G11', "JUMLAH PESERTA");
                $sheet->setCellValue('H11', "NO");
                $sheet->setCellValue('I11', "NIM");
                $sheet->setCellValue('J11', "NAMA");
                $sheet->setCellValue('K11', "PEKAN PERKULIAHAN");
                $sheet->setCellValue('L11', "KEHADIRAN MENGAJAR");
                $sheet->setCellValue('M11', "KEHADIRAN MAHASISWA");
                $sheet->setCellValue('N11', "PROSENTASE (%");


                //Formatting Table
                $sheet->getStyle('A1:N' . $row)->getFont()->setName('Times New Roman');
                $sheet->getStyle('A11:N' . $row)->getAlignment()->setWrapText(true);
                $sheet->getStyle("A12:B" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("D12:E" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("G12:H" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("K12:N" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getColumnDimension("A")->setWidth(4);
                $sheet->getColumnDimension("B")->setWidth(9);
                $sheet->getColumnDimension("C")->setWidth(16);
                $sheet->getColumnDimension("F")->setWidth(20);
                $sheet->getColumnDimension("J")->setAutoSize(true);


                try {
                    $sheet->getStyle('A11:N' . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
                } catch (Exception $e) {
                    dd($e);
                }
                $sheet->getStyle("N11:N" . $row)->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_PERCENTAGE);


                //Membuat Kepala Surat

                for ($row = 1; $row <= 10; $row++) {
                    try {
                        $sheet->mergeCells('A' . $row . ":N" . $row);
                    } catch (Exception $e) {
                    }
                    $sheet->getStyle('A' . $row . ":N" . $row)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                }
                $sheet->setCellValue('A1', "KEMENTERIAN PENDIDIKAN DAN KEBUDAYAAN");
                $sheet->setCellValue('A2', "INSTITUT TEKNOLOGI KALIMANTAN");
                $sheet->setCellValue('A3', "Kampus ITK Karang Joang, Balikpapan 76127");
                $sheet->setCellValue('A4', "Telepon (0542) 8530801 Faksimile (0542) 8530800N");
                $sheet->setCellValue('A5', "Surat elektronik : humas@itk.ac.id  laman : www.itk.ac.id");
                $sheet->setCellValue('A7', "REKAPITULASI MONITORING KEHADIRAN MAHASISWA SAMPAI DENGAN MINGGU KE " . $this->week);
                $sheet->setCellValue('A8', "PROGRAM STUDI " . strtoupper($this->PS_Nama));
                $sheet->setCellValue('A9', "TAHUN AKADEMIK " . strtoupper(Curiculum::all()->sortByDesc('KL_Date_Start')->first()->KL_Tahun_Kurikulum));

                $sheet->getStyle('A1')->getFont()->setSize('14');
                $sheet->getStyle('A2')->getFont()->setSize('14');
                $sheet->getStyle('A2')->getFont()->setBold('true');
                $sheet->getStyle('A3:A5')->getFont()->setSize('12');
                $sheet->getStyle('A6:N6')->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THICK);
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
        return $this->PS_Nama;
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
}

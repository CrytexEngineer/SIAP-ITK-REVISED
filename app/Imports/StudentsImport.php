<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class     StudentsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, SkipsOnError

{


    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function model(array $row)
    {
        $defaultpPassword = "$2y$10$/s2WnldgK8YjpyruqLk.NuGy1UFOpcRG844ICiMjXL1U01qRU420m";
        $students = Student::where('MA_Nrp', $row['ma_nrp'])->first();
        $data = ['MA_Nrp' => $row['ma_nrp'],
            'MA_NRP_Baru' => $row['ma_nrp_baru'],
            'MA_NamaLengkap' => $row['ma_namalengkap'],
            'MA_PASSWORD' => $defaultpPassword];
        if ($row['ma_email'] == "NULL") {
            $data['email'] = sprintf('%08d', (int)$row['ma_nrp_baru']) . "@student.itk.ac.id";
        } else {
            $data['email'] = $row['ma_email'];
        }


        if (!$students) {
            return new Student($data);
        }

        $students->update($data);
    }

    public function rules(): array
    {
        return [
            'ma_nrp' => ['required', 'integer'],
            'ma_namalengkap' => 'required',
        ];
    }

    public function onFailure(Failure ...$failures)
    {
    }

    public function batchSize(): int
    {
        return 100;
    }

    /**
     * @inheritDoc
     */
    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

}

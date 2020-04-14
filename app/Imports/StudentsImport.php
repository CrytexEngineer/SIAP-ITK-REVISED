<?php

namespace App\Imports;

use App\Employee;
use App\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class StudentsImport   implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, SkipsOnError,WithBatchInserts
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {


        $data = ['MA_Nrp' => $row['ma_nrp'],
            'MA_NRP_Baru' => $row['ma_nrp_baru'],
             'MA_Email' => $row['ma_email'],
            'MA_NamaLengkap' => $row['ma_namalengkap']];


        $students = Student::where('MA_Nrp', $row['ma_nrp'])->first();

        if (!$students) {
            return new Student($data);
        }

        $students->update($data);
    }

    public
    function rules(): array
    {
        return [
            'ma_nrp' => ['required','integer'],
            'ma_namalengkap' => 'required',
        ];
    }

    /**
     * @inheritDoc
     */
    public
    function onFailure(Failure ...$failures)
    {

    }


    /**
     * @inheritDoc
     */
    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }

    /**
     * @inheritDoc
     */
    public function batchSize(): int
    {
        return 100;
    }
}

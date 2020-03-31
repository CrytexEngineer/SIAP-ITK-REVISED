<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use phpDocumentor\Reflection\Types\Integer;
use Throwable;

class EmployeesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, SkipsOnError

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $data = ['PE_Nip' => $row['pe_nip'],
//            'PE_Email' => $row['pe_email'],
            'PE_NamaLengkap' => $row['pe_namalengkap'],
            'PE_Nama' => $row['pe_nama'],
            'PE_TipePegawai' => $row['pe_idjenispegawai'],];


        $employee = Employee::where('PE_Nip', $row['pe_nip'])->first();

        if (!$employee) {
            return new Employee($data);
        }

        $employee->update($data);
    }

    public
    function rules(): array
    {
        return [
            'pe_nip' => ['required','integer'],
            'pe_namalengkap' => 'required',
        ];
    }

    /**
     * @inheritDoc
     */
    public
    function onFailure(Failure ...$failures)
    {

    }

    public function batchSize(): int
    {
        return 10;
    }

    /**
     * @inheritDoc
     */
    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}

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
        $defaultpPassword="$2y$10$7TJnur9vdH.8kOZC5/ZqT.ZhJkx9W4fTNn3iIlo92.qiEVt1LoTMy";
        $data = ['PE_Nip' => $row['pe_nip'],
            'PE_NamaLengkap' => $row['pe_namalengkap'],
            'PE_Nama' => $row['pe_nama'],
            'password'=>$defaultpPassword
        ];

        if ($row['pe_email']!=null) {
            $data['PE_Email'] = $row['pe_email'];
        }



        $employee = Employee::where('PE_Nip', $row['pe_nip'])->first();

        if (!$employee) {

        return  new Employee($data);

        }

        $employee->update($data);
    }

    public
    function rules(): array
    {
        return [
            'pe_nip' => ['required', 'integer'],
            'pe_namalengkap' => 'required',
        ];
    }

    /**
     * @inheritDoc
     */
    public
    function onFailure(Failure ...$failures)
    {

        dump($failures);
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
        dd($e);
    }
}

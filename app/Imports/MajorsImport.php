<?php

namespace App\Imports;

use App\Major;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class MajorsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts,  SkipsOnError

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!Major::where('PS_Kode_Prodi', $row['ps_kode_prodi'])->first()) {

            return new Major([
                'PS_Kode_Prodi' => $row['ps_kode_prodi'],
                'PS_Nama' => $row['ps_nama']]);
        }

        $major = Major::where('PS_Kode_Prodi', '=', $row['ps_kode_prodi']);
        $data = ['PS_Kode_Prodi' => $row['ps_kode_prodi'],
            'PS_Nama' => $row['ps_nama']];

        $major->update($data);

    }

    public function rules(): array
    {
        return [
            'ps_kode_prodi' => 'required',
            'ps_nama_baru' => 'required',
        ];
    }

    /**
     * @inheritDoc
     */
    public function onFailure(Failure ...$failures)
    {
    }

    public function batchSize(): int
    {
        return 1000;
    }

    /**
     * @inheritDoc
     */
    public function onError(Throwable $e)
    {
        // TODO: Implement onError() method.
    }
}


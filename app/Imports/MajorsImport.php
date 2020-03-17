<?php

namespace App\Imports;

use App\Major;

use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class MajorsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
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

            $major = Major::where('PS_Kode_Prodi', '=', $row['ps_kode_prodi']);
            $major->update($row);

        }
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
dd($failures);
    }
}


<?php

namespace App\Imports;


use App\Khs;
use App\Major;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class KHSimportimplements implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{

    public function model(array $row)
    {
        if (!Khs::where('PS_Kode_Prodi', $row['ps_kode_prodi'])->first()) {

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
}


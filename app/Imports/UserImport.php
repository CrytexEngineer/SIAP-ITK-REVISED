<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!User::where('MK_ID', $row['mk_id'])->first()) {

            return new User
            ([
                'PS_Kode_Prodi' => $row['kode_prodi'],
                'PS_Nama_Baru' => $row['ps_nama_baru']]);

            $User = User::where('PS_Kode_Prodi', '=', $row['kode_prodi']);
            $User->update($row);

        }
    }

    public function rules(): array
    {
        return [
            'kode_prodi' => 'required',
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


<?php

namespace App\Imports;


use App\Khs;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;


class KHSImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, SkipsOnError
{

    public function model(array $row)
    {


        $Khs = Khs::where('KU_MA_Nrp', $row['ku_ma_nrp'])
            ->where('KU_KE_KR_MK_ID', $row['ku_ke_kr_mk_id'])->first();

        $data = ['KU_KE_Tahun' => $row['ku_ke_tahun'],
            'KU_MA_Nrp' => $row['ku_ma_nrp'],
            'KU_KE_KR_MK_ID' => $row['ku_ke_kr_mk_id'],
            'KU_KE_Kelas' => $row['ku_ke_kelas'],
            'KU_KE_KodeJurusan' => $row['ku_ke_kodejurusan'],];


        if (!$Khs) {
            return new Khs($data);
        }

        $Khs->update($data);


    }

    public function rules(): array
    {
        return [

        ];
    }


    public function onFailure(Failure ...$failures)
    {
    }

    /**
     * @inheritDoc
     */
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


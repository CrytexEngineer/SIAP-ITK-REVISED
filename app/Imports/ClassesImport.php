<?php

namespace App\Imports;

use App\Kelas;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;

class ClassesImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithBatchInserts, SkipsOnError

{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    public function model(array $row)
    {
        $data = ['KE_KR_MK_ID' => $row['ke_kr_mk_id'],
            'KE_Tahun' => $row['ke_tahun'],
            'KE_IDSemester' => $row['ke_idsemester'],
            'KE_Kelas' => $row['ke_kelas'],
            'KE_DayaTampung' => $row['ke_dayatampung'],
            'KE_PE_NIPPengajar' => $row['ke_pe_nippengajar'],
            'KE_Terisi' => $row['ke_terisi'],
            'KE_Jadwal_IDHari' => $row['ke_jadwal_idhari'],
            'KE_Jadwal_JamMulai' => $row['ke_jadwal_jammulai'],
            'KE_Jadwal_JamUsai' => $row['ke_jadwal_jamusai'],
            'KE_Jadwal_Ruangan' => $row['ke_jadwal_ruangan'],
            'KE_KodeJurusan' => $row['ke_kodejurusan']];

        $kelas = Kelas::where('KE_KR_MK_ID', $row['ke_kr_mk_id'])->where('KE_Kelas', $row['ke_kelas'])->first();


        if (!$kelas) {
            return new Kelas($data);
        }

        $kelas->update($data);

    }

    public function rules(): array
    {
        return [
            'ke_kr_mk_id' => ['required'],
            'ke_pe_nippengajar' => 'required',

        ];
    }

    /**
     * @inheritDoc
     */
    public function onFailure(Failure ...$failures)
    {
        dd($failures);
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
        dd($e);
        // TODO: Implement onError() method.
    }
}

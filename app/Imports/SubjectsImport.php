<?php

namespace App\Imports;

use App\Subject;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class SubjectsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{

    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (!Subject::where('MK_ID', $row['mk_id'])->first()) {

            return new Subject([

                'MK_ID' => $row['mk_id'],
                'MK_Mata_Kuliah' => $row['mk_mata_kuliah'],
                'MK_KreditKuliah' => $row['mk_kreditkuliah'],
                'MK_ThnKurikulum' => $row['mk_thnkurikulum'],

            ]);

        }

        $subject = Subject::where('MK_ID','=',$row['mk_id']);
        $subject->update($row);

    }

    public function rules(): array
    {
        return [
            'mk_id' => ['required'],
            'mk_mata_kuliah' => 'required',
            'mk_kreditkuliah' => 'required',
            'mk_thnkurikulum' => 'required'


        ];
    }

    /**
     * @inheritDoc
     */
    public function onFailure(Failure ...$failures)
    {

    }
}

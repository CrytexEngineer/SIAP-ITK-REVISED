<?php


use App\Presence;

function getKehadiran($MA_Nrp, $KE_ID, $PT_URUTAN){

    $presences=   Presence::JOIN('meetings','presences.PR_KE_ID','meetings.PT_KE_ID')
        ->JOIN('class_student','class_student.KU_ID','presences.PR_KU_ID')
            ->WHERE('class_student.KU_MA_Nrp',$MA_Nrp)
            ->WHERE('presences.PR_KE_ID',$KE_ID)
            ->WHERE('meetings.PT_Urutan',$PT_URUTAN)->get()->first();



      return substr($presences['PR_Keterangan'],0,1);


}

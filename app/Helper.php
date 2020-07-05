<?php


//function getKehadiran($MA_Nrp, $KE_ID, $PT_URUTAN){

//    $presences=   Presence::JOIN('meetings','presences.PR_PT_ID','meetings.PT_ID')
//        ->JOIN('class_student','class_student.KU_ID','presences.PR_KU_ID')
//            ->WHERE('class_student.KU_MA_Nrp',$MA_Nrp)
//            ->WHERE('presences.PR_KE_ID',$KE_ID)
//            ->WHERE('meetings.PT_Urutan',3)->get()->first();
//
//
//    if ($presences != null){
//        return substr($presences['PR_Keterangan'],0,1);
//    }
//}

function getKehadiran($MA_Nrp, $KE_ID, $PT_URUTAN)
{

    $presences = DB::select("Select * from presences  inner join
    class_student on class_student.KU_ID = presences.PR_KU_ID
    inner join meetings on presences.PR_PT_ID= meetings.PT_ID
    where class_student.KU_MA_Nrp=" . $MA_Nrp . " and  presences.PR_KE_ID=" . $KE_ID . " and meetings.PT_Urutan=" . $PT_URUTAN);


    if ($presences != null) {
        return substr($presences[0]->{'PR_Keterangan'}, 0, 1);
    }

}

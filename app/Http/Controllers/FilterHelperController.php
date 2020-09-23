<?php

namespace App\Http\Controllers;


use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilterHelperController extends Controller
{

    public function subjectQuery(Request $request)
    {
        $user_major = Auth::user()->PE_KodeJurusan;
        if ($user_major == 0000 || $user_major == null) {
            $subject = Kelas::where('KE_KodeJurusan', '=', $request->input('PS_ID'))
                ->join('subjects', 'subjects.MK_ID', 'classes.KE_KR_MK_ID')->distinct('KE_KR_MK_ID')->get()->unique('KE_KR_MK_ID');
        } else {
            $subject = Kelas::where('KE_KodeJurusan', '=', $user_major)
                ->join('subjects', 'subjects.MK_ID', 'classes.KE_KR_MK_ID')->distinct('KE_KR_MK_ID')->get()->unique('KE_KR_MK_ID');
        }


        return response()->json([
            'subject' => $subject
        ]);
    }
}

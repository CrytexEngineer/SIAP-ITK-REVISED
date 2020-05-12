<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    protected $primaryKey = 'LB_ID';
    protected $fillable = ['LB_PE_Nip', 'LB_Notes', 'LB_Action_ID', 'LB_Table'];
    const ACTION_IMPORT = 'IMPORT';
    const ACTION_CREATE = 'CREATE';
    const ACTION_EDIT = 'EDIT';
    const ACTION_DELETE = 'DELETE';


    const TABLE_EMPLOYEES = 'employees';
    const TABLE_STUDENTS = 'students';
    const TABLE_MAJORS = 'majors';
    const TABLE_SUBJECTS = 'subjects';
    const TABLE_CLASSES = 'classes';
    const TABLE_CLASS_STUDENT = 'class_student';
    const TABLE_CLASS_EMPLOYEE = 'class_employee';
    const TABLE_EMPLOYEE_ROLE = 'employee_role';

    public static function write($PE_Nip, $LB_Notes, $LB_Action_ID, $LB_Table)
    {
        date_default_timezone_set("Asia/Kuala_Lumpur");
        $logbook = new Logbook([
            'LB_PE_Nip' => $PE_Nip,
            'LB_Notes' => $LB_Notes,
            'LB_Table' => $LB_Table,
            'LB_Action_ID' => $LB_Action_ID]);

        $logbook->save();
    }


}



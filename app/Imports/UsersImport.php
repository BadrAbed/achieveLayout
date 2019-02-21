<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 11/1/2018
 * Time: 12:39 PM
 */

namespace App\Imports;

use App\EducationLevel;
use App\SchoolLinkedGrads;
use App\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Session;

class UsersImport implements ToCollection
{
    private $school_id;

    function __construct()
    {
        $this->school_id = Auth::guard('school')->user()->id;
    }

    public function collection(Collection $rows)
    {

        $arraya = [];
        for ($i = 0; $i < count($rows); $i++) {
            $arraya[$i] = $rows[$i];
        }

        $errors = [];
        $array = [];

        if (count($arraya) < 2) {

            $errors['emptyFile'] = 'الملف فراغ ';
        }

        for ($i = 1; $i < count($rows->toArray()); $i++) {
            $array[] = $rows->toArray()[$i][0];
        }
        if ($rows->toArray()[0][0] != 'البريد الاكترونى') {
            $errors['headerOfFile'] = 'من فضلك ادخل البيانات فى الملف المحمل من الموقع  ';
        }

        if (count(array_unique($array)) < count($array)) {
            $errors['valuesInfile'] = 'بعض الاميلات مكررة فى الملف: ';
        }


        foreach ($rows as $row) {
            if (isset($row[0])) {
                $checkIFEmailInsertBeforeOrnot = User::where('email', $row[0])->first();
                if ($checkIFEmailInsertBeforeOrnot != null) {
                    // abort(500, 'ffff');
                    $errors['emailRepeat'] = '  بعض الاميلات موجوده بالفعل فى قاعدة البيانات مثل : ' . $checkIFEmailInsertBeforeOrnot->email;
                }
                if (!filter_var($row[0], FILTER_VALIDATE_EMAIL)) {
                    $errors['inValidEmail'] = (" $row[0] ايميل غير صحيح ") . ':' . ' ادخل اميل مثل :john.doe@example.com';
                }
                if ($row[0] == 'البريد الاكترونى') {

                    continue;
                }
            }


            if (!isset($row[0]) || !isset($row[1]) || !isset($row[2]) || !isset($row[3])) {
                //abort(500, 'ddd');
                $errors['emptyFildes '] = 'بعض القيم فارغه من فضلك اكمل الملف اولا';
            }


            $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
            $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->get()->pluck('id')->toArray();
            if (count($educationLevels) == 0) {
                $educationLevels = EducationLevel::where('parent_id', null)->get()->pluck('id')->toArray();
            }
            if (isset($row[2])) {
                if (!in_array($row[2], $educationLevels)) {
                    // abort(403, 'ليس موجود');
                    $errors['levelNotAllow'] = 'بعض الصفوف غير مسموح لك بها  ';
                }
                if (!is_numeric($row[2])) {
                    // abort(403, 'ليس موجود');
                    $errors['levelNotAllow'] = 'الصفوف يجب ان تكون ارقام وليست حروف : ' . '( ' . $row[2] . ' ) ' . 'رقم صف خطا';
                }
            }


        }

        $users = User::where('school_id', Auth::guard('school')->user()->id)->get()->count();
        $res = Auth::guard('school')->user()->numberOfStudents - $users;
        if (count($rows) > $res + 1) {


            $errors['accountsVolition'] = 'لقد تعديت عدد الطلاب المسموح لك بها';
        }
        if (count($errors) > 0) {
            Session::put('errors', $errors);

        } else {

            DB::transaction(function () use ($rows) {
                foreach ($rows as $row) {

                    if ($row[0] == 'البريد الاكترونى') {
                        continue;
                    }
                    User::create([
                        'email' => $row[0],
                        'name' => $row[1],

                        'student_grade_id' => $row[2],
                        'password' => bcrypt($row[3]),

                        'student_country_id' => Auth::guard('school')->user()->countries,
                        'school_id' => $this->school_id,
                    ]);
                }
            });
        }

    }
}
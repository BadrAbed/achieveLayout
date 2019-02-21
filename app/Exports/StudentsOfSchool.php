<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 11/1/2018
 * Time: 9:32 AM
 */

namespace App\Exports;

use App\EducationLevel;
use App\SchoolLinkedGrads;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class StudentsOfSchool implements FromCollection, WithHeadings, WithTitle, WithMultipleSheets
{

    protected $level;
    protected $levelName;
    protected $count;


    public function __construct($level, $levelName)
    {
        $this->level = $level;
        $this->levelName = $levelName;

    }

    public function collection()
    {

        return User::where('school_id', Auth::guard('school')->user()->id)->whereIn('student_grade_id', $this->level)->orderBy('student_grade_id')->get(['id', 'name', 'email', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'الكود',
            'الاسم',
            'الاميل',
            'تاريخ الالتحاق',
        ];
    }

    public function sheets(): array
    {
        $sheets = [];

        $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
        $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->get();
        if ($educationLevels->count() == 0) {
            $educationLevels = EducationLevel::where('parent_id', null)->get();
        }
        foreach ($educationLevels as $levels) {
            $child_id = EducationLevel::where('parent_id', $levels->id)->get()->pluck('id')->toArray();
            $child_id['parent_id'] = $levels->id;

            $sheets[] = new StudentsOfSchool($child_id, $levels->name);
        }

        return $sheets;
    }

    public function title(): string
    {

        return $this->levelName;
    }

}
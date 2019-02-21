<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 11/1/2018
 * Time: 12:15 PM
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

class levelsOfSchool implements FromCollection, WithHeadings
{
    public function collection()
    {
        $userAllowedGrades = SchoolLinkedGrads::where('school_id', Auth::guard('school')->user()->id)->get()->pluck('grade_id')->toArray();
        $educationLevels = EducationLevel::whereIn("id", $userAllowedGrades)->get(['id','name']);

        if ($educationLevels->count() == 0) {
            $educationLevels = EducationLevel::where('parent_id', null)->get(['id','name']);
        }
        return $educationLevels;
    }

    public function headings(): array
    {
        return [
            'الكود',
            'الاسم',

        ];
    }
}
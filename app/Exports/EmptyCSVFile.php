<?php
/**
 * Created by PhpStorm.
 * User: badr.abed
 * Date: 11/1/2018
 * Time: 12:16 PM
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

class EmptyCSVFile implements WithHeadings
{
    public function headings(): array
    {
        return [
            'البريد الاكترونى',
            'الاسم',
            'المستوى',
            'كلمة السر',

        ];
    }
}
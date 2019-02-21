<?php

namespace App\Http\Controllers;

use App\Dictionary;
use App\EducationLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class DictionaryController extends Controller
{

    public function index()
    {
        return view('admin.dictionary.index');
    }

    public function ajaxAllWords()
    {

        $data = Dictionary::with('grade')->orderBy("word", "asc")->get();

        $arr = [];
        foreach ($data as $row) {

            if (@$_GET["word"]) {
                if (strstr($row->word, $_GET["word"]) == false) {
                    continue;
                }
            }
            if (@$_GET["grade"]) {

                if (strstr($row->grade->name, $_GET["grade"]) == false) {

                    continue;
                }
            }
            if ($_GET["type"]) {

                if (strstr((string)$row->type, (string)$_GET["type"]) == false) {

                    continue;
                }
            }
            $parent = EducationLevel::where('id', $row->grade->parent_id)->first();

            $arr[] = array("ID" => htmlspecialchars($row->id, ENT_QUOTES), "meaning" => htmlspecialchars($row->meaning, ENT_QUOTES), "word" => htmlspecialchars($row->word, ENT_QUOTES), "grade" => htmlspecialchars($row->grade->name . "-" . $parent->name, ENT_QUOTES), "type" => htmlspecialchars(($row->type), ENT_QUOTES));
            unset($row);
        }

//dd($arr);
        return response()->json($arr);

    }

    public function create()
    {

        $edu_levels = EducationLevel::with('children')->get();
        return view('admin.dictionary.create', compact('edu_levels'));

    }

    public function view($id)
    {

        $word = Dictionary::find($id);

        return view('admin.dictionary.view', compact('word'));

    }

    public function delete($id)
    {


        Session::flash('message', 'تم مسح  الكلمه ');
        $word = Dictionary::find($id)->delete();

        return Redirect::back();

    }

    public function edit($id)
    {
        $edu_levels = EducationLevel::with('children')->get();
        $word = Dictionary::find($id);

        return view('admin.dictionary.edit', compact('word'), compact('edu_levels'));

    }

    public function update(Request $request, $id)
    {

        $checkIfIdIsChild = EducationLevel::where('parent_id', $request->education_level_id)->get();//if grade id is not child or was parent to any other grade , then this is not valid
        if ($checkIfIdIsChild->count() > 0) {
            $isValidGradeArr = [];
        } else {

            $isValidGradeArr = [$request->education_level_id];

        }
        request()->validate([
            'word' => 'required|max:191',
            'education_level_id' => 'required|in:' . implode(",", $isValidGradeArr),//validate that the choice has been selected within the allowed values
            'type' => "required",
            'meaning' => 'required',
            'examples' => 'required|max:5000',
            'meaning_in_english' => 'max:191',
            'relative_words' => 'required|max:1000',


        ],
            ['word.required' => 'الكلمة مطلوبه',

                'word.max' => 'الكلمه لاتزيد عن 191 حرف',
                'education_level_id.required' => 'مستوى الكلمه مطلوب',
                'type.required' => 'نوع الكلمة مطلوب',
                'meaning.required' => 'معنى الكلمة مطلوب',
                'examples.required' => 'الامثله على الكلمه مطلوب  ',
                'examples.max' => ' الامثله لاتزيد عن 5000 حرف  ',

                'meaning_in_english.max' => 'المعنى ف الانجليزيه لا يزيد عن 191 حرف',

                'relative_words.max' => 'الكلمات القريبه لا تزيد عن 1000 حرف ',
                'relative_words.required' => 'الكلمات القريبه مطلوبه ',
            ]);
        $word = Dictionary::find($id);

        $word->word = $request->word;
        $word->type = $request->type;
        $word->meaning = $request->meaning;
        $word->examples = $request->examples;
        $word->relative_words = $request->relative_words;
        $word->meaning_in_english = $request->meaning_in_english;
        $word->education_level_id = $request->education_level_id;

        $word->save();
        Session::flash('message', 'تم تعديل  الكلمه ');
        return Redirect::back();

    }

    public function store(Request $request)
    {


        $checkIfIdIsChild = EducationLevel::where('parent_id', $request->education_level_id)->get();//if grade id is not child or was parent to any other grade , then this is not valid


        // a work around that solve a problem of the register controller with the manual validators
        //its about to check if the grade has children or not
        //if has , then its not valid , and send to the validator an empty array , so he will fire automatic error and vice versa
        if ($checkIfIdIsChild->count() > 0) {
            $isValidGradeArr = [];
        } else {

            $isValidGradeArr = [$request->education_level_id];

        }
        request()->validate([
            'word' => 'required|max:191|unique:dictionaries',
            'education_level_id' => 'required|in:' . implode(",", $isValidGradeArr),//validate that the choice has been selected within the allowed values
            'type' => "required",
            'meaning' => 'required',
            'examples' => 'required|max:5000',
            'meaning_in_english' => 'max:191',
            'relative_words' => 'required|max:1000',


        ],
            ['word.required' => 'الكلمة مطلوبه',
            'word.unique' => 'الكلمة موجوده بالفعل',
                'word.max' => 'الكلمه لاتزيد عن 191 حرف',
                'education_level_id.required' => 'مستوى الكلمه مطلوب',
                'type.required' => 'نوع الكلمة مطلوب',
                'meaning.required' => 'معنى الكلمة مطلوب',
                'examples.required' => 'الامثله على الكلمه مطلوب  ',
                'examples.max' => ' الامثله لاتزيد عن 5000 حرف  ',

                'meaning_in_english.max' => 'المعنى ف الانجليزيه لا يزيد عن 191 حرف',

                'relative_words.max' => 'الكلمات القريبه لا تزيد عن 1000 حرف ',
                'relative_words.required' => 'الكلمات القريبه مطلوبه ',
            ]);

        $word = new Dictionary();
        $word->word = $request->word;
        $word->type = $request->type;
        $word->meaning = $request->meaning;
        $word->examples = $request->examples;
        $word->relative_words = $request->relative_words;
        $word->meaning_in_english = $request->meaning_in_english;
        $word->education_level_id = $request->education_level_id;

        $word->save();
        Session::flash('message', 'تمت اضافه الكلمه الى القاموس');
        return Redirect::to('dictionary/create/word');
    }
}

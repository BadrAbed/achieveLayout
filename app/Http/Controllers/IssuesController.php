<?php

namespace App\Http\Controllers;

use App\Content;
use App\Http\Controllers\Controller;
use App\Issues;
use Illuminate\Http\Request;

class IssuesController extends Controller {
    public function store($content_id, $tab_num) {

        request()->validate([
            'title' => 'required|max:191',
            'name' => 'required',

        ],
            ['title.required' => 'العنوان مطلوب',

                'title.max' => 'العنوان لا يزيد عن 191 حرف',
                'name.required' => 'الملاحظه مطلوبه',

            ]);
        $row = new Issues();
        $row->name = \request('name');
        $row->title = \request('title');
        $row->content_id = $content_id;
        $row->status = 0;
        $row->user_id = auth()->id();
        $row->tab_number = $tab_num;
        if (\request('question_id')) {
            $row->question_id = request('question_id');
        }
        $row->save();
        return redirect()->back();
    }

    public function view($content_id) {
        $content_issues = Issues::where('content_id', $content_id)->get();
        $content = Content::find($content_id);
        return view('issues.view')->with(compact('content_issues', 'content_id', 'content'));
    }
    public function update($question_id, $tab_num) {

        $data = request()->validate([
            'title' => 'required|max:191',
            'name' => 'required',

        ],
            ['title.required' => 'العنوان مطلوب',

                'title.max' => 'العنوان لا يزيد عن 191 حرف',
                'name.required' => 'الملاحظه مطلوبه',

            ]);
        Issues::where('question_id', $question_id)->where('tab_number', $tab_num)->update($data);
        return redirect()->back();
    }
}

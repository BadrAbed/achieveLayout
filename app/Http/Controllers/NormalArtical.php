<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use App\Sound;
use Input;
use Session;
use App\VoiceReaderModel;
use App\Content;
use App\Http\OwnClasses\Permissions;

class NormalArtical extends Controller
{
//    public function __construct()
//    {
//        $this->middleware("Permissions:content");//permissions middleware
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $content_id)
    {
        return view('admin.normal_artical.create', compact("content_id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $content_id)
    {
        $checkIfHascontentOrnot = \App\NormalArtical::where('content_id', $content_id)->get();
        if ($checkIfHascontentOrnot->count() > 0) {
            return \redirect()->back()->withErrors('هذا الموضوع لديه مقال موسع بالفعل');

        }
        request()->validate([
            'article' => 'required',

            'sound' => 'required|mimes:mpga,wav| max:20000',


        ],
            ['article.required' => 'من فضلك ادخل المقال المفصل ',

                'sound.required' => 'من فضلك اختر ملف صوت ',
                'sound.mimes' => 'من فضلك اختر ملف صوت من نوع   wav او mp3  ',
                'sound.max' => ' الملف  يجب ان لايزيد عن 20 ميجا   ',

            ]);

        $file = $request->file('sound');


        $extension = $file->getClientOriginalExtension();
        $sha1 = sha1($file->getClientOriginalName());
        $filename = time() . "_" . $sha1 . "." . $extension;
        //Move Uploaded File
        $destinationPath = 'sounds/';
        $pathname = 'sounds/' . $filename;


        $sound = new Sound;
        $sound->content_id = $content_id;
        $sound->sound_name = $filename;
        $sound->path = $pathname;
        $sound->size = $file->getSize();
        $sound->type = $file->getClientOriginalExtension();
        $sound->length = request('duration');
        $sound->save();
        $file->move($destinationPath, $filename);
        // $sound->guid=

        $article = new \App\NormalArtical;
        $article->article = Input::get('article');
        $article->sound_id = $sound->id;
        $article->content_id = $content_id;
        $article->save();

        //  print_r($file);die();
        Session::put('normal', 'normal');

        //return redirect("voiceSentences/create/create/NA/$article->id");//NA means normal articles , navigate to this controller for more documented comments.

        if (auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::LEADER && auth()->user()->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::SUPER_ADMIN) {
            return redirect('stretch-artical/create/' . $content_id);
        }
        return Redirect::to('createquestion/'.\App\Http\OwnClasses\STUDENT_ASSIGNED_LESSON_PLANS_ENUMS::GET_SHORT_QUESTIONS_TAB_ENUM .'/'. $content_id);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $tab_enum)
    {

        $content_id = $id;
        $content = Content::with('Links', 'articalnormal', 'articalstrach', 'vocab')->find($id);

        $normal = \App\NormalArtical::with('sound')->where('content_id', $id)->first();


        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {

            $isAllowedStudentLessonAccess = CommonStudentLessonsProcesses::studentEachLessonAccess($content_id); // make some processes and checks before navigate to the view

            $isAllowedStudentTabAccess = CommonStudentTabsProcesses::isStudentAllowedToAccessThisTab($content_id, $tab_enum);


            if ($isAllowedStudentLessonAccess == false || $isAllowedStudentTabAccess == false) { // if it not allowed to access this content or this tab , navigate him to no premissions page

                return Redirect::back()->withErrors(["الرجاء الانتهاء من كل الخطوات السابقه لتتمكن من الدخول للمرحله التاليه"]);

            }

            CommonStudentTabsProcesses::EachTabAccessProcesses($tab_enum, $content_id);


            return view('student.content.normal_artical.show')->with(compact('normal'))->with(compact('content'))->with(compact('content_id'));
        } else {
            return view('admin.content.normal_artical.show')->with(compact('normal'))->with(compact('content'))->with(compact('content_id'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)


    {
        $content_id = $id;
        $content = \App\NormalArtical::with('sound')->where('content_id', $id)->first();

        return view('admin.normal_artical.edit')->with(compact('content'))->with(compact('content_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $content_id)
    {
        request()->validate([
            'sound' => 'mimes:mpga,wav| max:20000',
        ],
            [
                'sound.mimes' => 'من فضلك اختر ملف صوت من نوع   wav او mp3  ',
                'sound.max' => ' الملف  يجب ان لا تزيد عن 20 ميجا   ',
            ]);

        $article = \App\NormalArtical::where('content_id', $content_id)->first();
        if ($request->has('sound')) {
            if ($article) {

                $sound = Sound::where('id', $article->sound_id)->first();
                @unlink($sound->path);  //delete old file
            } else {
                $sound = new Sound;
            }
            $file = $request->file('sound');
            $extension = $file->getClientOriginalExtension();
            $sha1 = sha1($file->getClientOriginalName());
            $filename = time() . "_" . $sha1 . "." . $extension;
            //Move Uploaded File
            $destinationPath = 'sounds/';
            $pathname = 'sounds/' . $filename;
            $sound->content_id = $content_id;
            $sound->sound_name = $filename;
            $sound->path = $pathname;
            $sound->size = $file->getSize();
            $sound->type = $file->getClientOriginalExtension();
            $sound->length = request('duration');
            $sound->save();
            $file->move($destinationPath, $filename);
        }
        if ($article == null) {
            $article = new \App\NormalArtical;
            $article->content_id = $content_id;
            $article->sound_id = $sound->id;
        }
        $article->article = Input::get('article');
        $article->save();
        Session::flash('message', 'لقد تم التعديل  بنجاح');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}

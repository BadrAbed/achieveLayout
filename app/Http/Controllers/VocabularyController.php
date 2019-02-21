<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ContentController;
use App\Vocabulary;
use App\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Input;
use Session;
use DB;

class VocabularyController extends Controller
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


        // get all the nerds
        $vocabularys = Vocabulary::all();

        // load the view and pass the nerds
        return View::make('admin.vocabulary.index')
            ->with('vocabularys', $vocabularys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($content_id)
    {


        // load the create form (app/views/nerds/create.blade.php)
        return View::make('admin.vocabulary.create', compact('content_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $content_id)
    {
        request()->validate([

            'vocab.*.word' => 'required|max:191',
            'vocab.*.meaning' => 'required|max:191',


        ],
            [
                'vocab.*.word.required' => 'من فضلك ادخل اسم المصطلح',
                'vocab.*.word.max' => 'اسم المصطلح يجب الا يزيد عن 191 حرف',
                'vocab.*.meaning.max' => 'معنى المصطلح يجب الا يزيد عن 191 حرف',
                'vocab.*.meaning.required' => 'من فضلك ادخل معنى المصطلح',

            ]);


        $data = [];
        //return $request;
        $vocabs = $request->input('vocab');

        if (is_array($vocabs) || is_object($vocabs)) {
            foreach ($vocabs as $vocab) {

                $array = array(
                    'word' => $vocab['word'],
                    'meaning' => $vocab['meaning'],
                    'content_id' => $content_id,
                );
                array_push($data, $array);
            }
//            print_r($data);
//            die();
        }
        Vocabulary::insert($data);

        // redirect
        if (Session::get('messagebar') != null) {

            return Redirect::to('show_voc_content/' . $request->content_id);

        }
        Session::flash('message', 'لقد تم ادخال المصطلح بنجاح');
        return Redirect::to('content');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // get the nerd
        $vocabularys = Vocabulary::find($id);

        // show the view and pass the nerd to it
        return View::make('admin.vocabulary.show')
            ->with('vocabularys', $vocabularys);
    }

    public function show_voc_content($content_id)
    {

        // get the nerd
        //$content = Content::with('Country', 'grade', 'Categories','LearingGoal')->find(Session::get('content_id'))->first();
        $vocabularys = Vocabulary::where('content_id', $content_id)->get();

        // show the view and pass the nerd to it
        return View('admin.vocabulary.view_vocab_content')
            ->with('vocabularys', $vocabularys)->with(compact('content_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get the nerd

        $vocabularys = Vocabulary::find($id);
        $content = Content::with('Country', 'grade', 'Categories', 'LearingGoal')->find(Session::get('content_id'))->first();
        $content_id = $vocabularys->content_id;
        // show the edit form and pass the nerd
        return View::make('admin.vocabulary.edit')
            ->with('vocabularys', $vocabularys)->with('content', $content)->with(compact('content_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $validator = Validator::make(Input::all(), [

            'word' => 'required|max:191',
            'meaning' => 'required|max:191',


        ], [
            'word.required' => 'من فضلك ادخل اسم المصطلح',
            'word.max' => 'اسم المصطلح يجب الا يزيد عن 191 حرف',
            'meaning.max' => 'معنى المصطلح يجب الا يزيد عن 191 حرف',
            'meaning.required' => 'من فضلك ادخل معنى المصطلح',

        ]);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('vocabularys/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $vocabularys = Vocabulary::find($id);
            $vocabularys->word = Input::get('word');
            $vocabularys->meaning = Input::get('meaning');

            $vocabularys->save();

            // redirect
            Session::flash('message', 'لقد تم تعديل المصطلح بنجاح');
            return Redirect::to('show_voc_content/' . $vocabularys->content_id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // delete
        $vocabularys = Vocabulary::find($id);
        $vocabularys->delete();

        // redirect
        Session::flash('message', 'لقد تم حذف المصطلح بنجاح');
        return Redirect::to('vocabularys');
    }
}

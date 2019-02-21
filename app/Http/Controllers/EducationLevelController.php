<?php

namespace App\Http\Controllers;

use App\EducationLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Content;
use Input;
use Session;
use App\LogTime;

class EducationLevelController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware("Permissions:grades");//permissions middleware
//    }

    public function index()
    {


        // get all the nerds
        $educationlevels = EducationLevel::with('children')->whereNull('parent_id')->get();

        // load the view and pass the nerds
        return View::make('admin.educationLevel.index')
            ->with('educationlevels', $educationlevels);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form (app/views/nerds/create.blade.php)
        return View::make('admin.educationLevel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validate
        // read more on validation at http://laravel.com/docs/validation

        $nameOfEductionLevel = EducationLevel::where(['name' => Input::get('name'), 'parent_id' => Input::get('parent_id')])->first();
        if ($nameOfEductionLevel) {
            return Redirect::to('education-level')->withErrors(['المرحله  موجوده بالفعل ']);
        }
        request()->validate([
            'name' => 'required|max:191|',


        ],
            [
                'name.required' => 'من فضلك ادخل   اسم المرحله العمريه  ',
                'name.max' => 'من فضلك  اسم المرحله العمريه يجب الا يزيد عن 191',
            ]);

        /*  $validator = Validator::make(Input::all(), $rules);

          // process the login
          if ($validator->fails()) {
              return Redirect::to('education-level/create')
                  ->withErrors($validator)
                  ->withInput(Input::except('password'));
          } else {*/
        // store


        $educationlevels = new EducationLevel;
        $educationlevels->name = Input::get('name');
        $educationlevels->parent_id = Input::get('parent_id');
        $educationlevels->save();


//        $newlog = array(
//            'name' => $educationlevels->name,
//            'type' => 'add',
//            'user_id' => auth()->user()->id,
//            'table_name' => 'educationlevel',
//            'created_at' => date("Y-m-d H:i:s"),
//
//        );
//        LogTime::insert($newlog);
        // redirect
        Session::flash('message', 'لقد تم ادخال المرحله  بنجاح');
        return Redirect::to('education-level');

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
        return Redirect::to('education-level');
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
        $educationlevels = EducationLevel::find($id);

        // show the edit form and pass the nerd
        return View::make('admin.educationLevel.edit')
            ->with('educationlevel', $educationlevels);
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
        // validate
        // read more on validation at http://laravel.com/docs/validation
        $messages = ['name.required' => 'من فضلك ادخل   اسم المرحله العمريه  ',
            'name.max' => 'من فضلك  اسم المرحله العمريه يجب الا يزيد عن 191',];
        $rules = array(
            'name' => 'required|max:191'

        );
        $validator = Validator::make(Input::all(), $rules, $messages);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('education-level/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $educationlevels = EducationLevel::find($id);
            $educationlevels->name = Input::get('name');

            $educationlevels->save();
//            $newlog = array(
//                'name' => $educationlevels->name,
//                'type' => 'edit',
//                'user_id' => auth()->user()->id,
//                'table_name' => 'educationlevel',
//                'created_at' => date("Y-m-d H:i:s"),
//
//            );
//            LogTime::insert($newlog);

            // redirect
            Session::flash('message', 'لقد تم تعديل البلد بنجاح');
            return Redirect::to('education-level');
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
        $educationlevels = EducationLevel::find($id);
        $cildCatg = EducationLevel::where('parent_id', $id)->get();
        $contents = Content::where('education_level_id', $id)->first();

        if ($contents == null) {
            $newlog = array(
                'name' => $educationlevels->name,
                'type' => 'delete',
                'user_id' => auth()->user()->id,
                'table_name' => 'educationlevel',
                'created_at' => date("Y-m-d H:i:s"),

            );
            if ($cildCatg->count() > 0) {
                foreach ($cildCatg as $cildCatg)
                    $cildCatg->delete();
            }
            $educationlevels->delete();

//            LogTime::insert($newlog);
            Session::flash('message', 'لقد تم حذف المرحله بنجاح');
            return Redirect::to('education-level');
        } else {
            Session::flash('alert', 'لايمكنك المسح ');
            return Redirect::to('education-level');
        }
        // redirect

    }


}

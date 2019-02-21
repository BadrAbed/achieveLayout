<?php

namespace App\Http\Controllers;

use App\Country;
use App\LogTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Input;
use App\Content;
use Session;

class CountryController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware("Permissions:country");//permissions middleware
//    }

    public function index()
    {
        // get all the nerds
        $countrys = Country::all();


        // load the view and pass the nerds
        return View::make('admin.country.index')->with('countrys', $countrys);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // load the create form (app/views/nerds/create.blade.php)
        return View::make('admin.country.create');
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


        // $validator = Validator::make(Input::all(), $rules);
        request()->validate([
            'name' => 'required|unique:country|max:191',
            'value' => 'required|unique:country|max:191',


        ],
            [
                'name.required' => 'من فضلك ادخل  ادخل اسم البلد ',
                'name.max' => 'اسم الدوله لا يجب ان يزيد عن 191 حرف ',
                'value.max' => 'قيمة البلد لا يجب ان تزيد عن 191 حرف',
                'value.required' => 'من فضلك ادخل قيمه البلد  ',
                'value.unique' => 'تكرار القيمه ممنوع  ',]);

        // process the login

        // store
        $countrys = new Country;
        $countrys->name = Input::get('name');
        $countrys->value = Input::get('value');

        $countrys->save();
//        $newlog = array(
//            'name' => $countrys->name,
//            'type' => 'add',
//            'user_id' => auth()->user()->id,
//            'table_name' => 'country',
//            'created_at' => date("Y-m-d H:i:s")
//
//        );
//        LogTime::insert($newlog);
        // redirect
        Session::flash('message', 'لقد تم ادخال البلد بنجاح');
        return Redirect::to('country');

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
        return Redirect::to('country');
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
        $countrys = Country::find($id);

        // show the edit form and pass the nerd
        return View::make('admin.country.edit')
            ->with('country', $countrys);
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


        $messages = [
            'name.required' => 'من فضلك ادخل  ادخل اسم البلد ',
            'name.max' => 'اسم الدوله لا يجب ان يزيد عن 191 حرف ',
            'value.max' => 'قيمة البلد لا يجب ان تزيد عن 191 حرف',
            'value.required' => 'من فضلك ادخل قيمه البلد  ',
            'value.unique' => 'تكرار القيمه ممنوع  ',];

        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = array(
            'name' => 'required|unique:country,name,' . $id . 'max:191',
            'value' => 'required|unique:country,value,' . $id . '|max:191',

        );
        $validator = Validator::make(Input::all(), $rules, $messages);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('country/' . $id . '/edit')
                ->withErrors($validator)
                ->withInput(Input::except('password'));
        } else {
            // store
            $countrys = Country::find($id);
//            $newlog = array(
//                'name' => $countrys->name,
//                'type' => 'edit',
//                'user_id' => auth()->user()->id,
//                'table_name' => 'country',
//                'created_at' => date("Y-m-d H:i:s")
//
//            );
            $countrys->name = Input::get('name');
            $countrys->value = Input::get('value');


            $countrys->save();
//            LogTime::insert($newlog);
            // redirect
            Session::flash('message', 'لقد تم تعديل البلد بنجاح');
            return Redirect::to('country');
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
        $countrys = Country::find($id);
        $contents = Content::where('countries', $countrys->id)->first();

        if ($contents == null) {
            $newlog = array(
                'name' => $countrys->name,
                'type' => 'delete',
                'user_id' => auth()->user()->id,
                'table_name' => 'country',
                'created_at' => date("Y-m-d H:i:s")

            );

            $countrys->delete();
//            LogTime::insert($newlog);
            Session::flash('message', 'لقد تم حذف البلد بنجاح');
            return Redirect::to('country');
        } else {

            Session::flash('alert', 'لايمكنك المسح ');
            return Redirect::to('country');
        }
        // redirect


    }
}

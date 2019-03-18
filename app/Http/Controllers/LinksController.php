<?php

namespace App\Http\Controllers;

use App\Links;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Input;
use Session;

class LinksController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('admin.links.create')->with('content_id', $id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'links.*.link' => 'required|max:194',
            'links.*.href' => array(
                'required',
                'regex:/^(https:\/\/).([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
                'max:600'
            ),

        ],
            ['links.*.link.required' => 'من فضلك ادخل اسم الرابط',
                'links.*.href.required' => 'من فضلك ادخل الرابط',
                'links.*.link.max' => 'من فضلك  الرابط يجب الا يزيد عن  191 حرف',
                'links.*.href.max' => 'من فضلك  الرابط يجب الا يزيد عن 600 حرف',

                'links.*.href.regex' => 'من فضلك ادخل الرابط بشكل صحيح مثل https://laravel.com ',
            ]);
        $data = [];
        //return $request;
        $links = $request->input('links');


//        if (is_array($links) || is_object($links)){
        foreach ($links as $link) {

            $array = array(
                'link' => $link['link'],
                'href' => $link['href'],
                'content_id' => $request->content_id,
            );
            array_push($data, $array);
            $row = new Links();
            $row->link = $link['link'];
            $row->href = $link['href'];
            $row->content_id = $request->content_id;
            $row->save();
        }


//        }

//        Links::insert($data);
        Session::flash('message', 'تم اضافه الروابط بنجاج');
        return Redirect::to('/links/' . $request->content_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Links $links
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $links = \App\Links::where('content_id', $id)->get();
        return view('admin.links.view')->with('links', $links)->with('content_id', $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Links $links
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $links = \App\Links::find($id);
        return view('admin.links.edit')->with('links', $links)->with('content_id', $links->content_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Links $links
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {


        request()->validate([
            'link' => 'required|max:194',
            'href' => array(
                'required',
                'regex:/^(https:\/\/|http:\/\/).([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',

                'max:600'
            ),

        ],
            ['link.required' => 'من فضلك ادخل اسم الرابط',
                'href.required' => 'من فضلك ادخل الرابط',
                'link.max' => 'من فضلك  الرابط يجب الا يزيد عن  191 حرف',
                'href.max' => 'من فضلك  الرابط يجب الا يزيد عن 600 حرف',

                'href.regex' => 'من فضلك ادخل الرابط بشكل صحيح مثل https://laravel.com ',
            ]);
        //  $validator = Validator::make(Input::all(), $rules);

        // process the login
        /* if ($validator->fails()) {
             return Redirect::to('/links/' . $id . '/edit')
                 ->withErrors($validator)
                 ->withInput(Input::except('password'));
         } else {*/
        // store
        $links = Links::find($id);
        $links->link = Input::get('link');
        $links->href = Input::get('href');
        $links->content_id = Session::get('content_id');
        $links->save();

        // redirect
        Session::flash('message', 'لقد تم تعديل الرابط بنجاح');
        return Redirect::to('/links/' . $links->content_id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Links $links
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

       Links::find($id)->delete();
        Session::flash('message', 'لقد تم الحذف  بنجاح');
        return \redirect()->back();
    }
}

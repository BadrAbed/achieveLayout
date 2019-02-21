<?php

namespace App\Http\Controllers;

use App\Content;
use App\EducationLevel;
use App\LogTime;
use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Input;
use phpDocumentor\Reflection\Types\Null_;
use Session;
use DB;

class CategoriesController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware("Permissions:categories");//permissions middleware
//    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories_all = Categories::with('children')->whereNull('parent_id')->get();
        $categories = DB::table('categories')->where('parent_id', NULL)->get();
        $sub_categories = [];
        $sub_sub_categories = [];
        foreach ($categories as $category) {
            $sub_categories[$category->id] = DB::table('categories')->where('parent_id', $category->id)->get();
            foreach ($sub_categories[$category->id] as $sub_category) {
                $sub_sub_categories[$sub_category->id] = DB::table('categories')->where('parent_id', $sub_category->id)->get();
            }
        }
//        print_r($categories);
//        print_r($sub_categories);
        $object = (object)$sub_categories;//        echo gettype($sub_categories);
        ;


//        print_r($sub_sub_categories);
        return view('admin.categories.index')->with('categories', $categories)->with('sub_categories', $sub_categories)->with('sub_sub_categories', $sub_sub_categories)->with(compact('categories_all'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories_all = Categories::all();

        $categories = DB::table('categories')->where('parent_id', NULL)->get();
        $sub_categories = [];
        $sub_sub_categories = [];
        foreach ($categories as $category) {
            $sub_categories[$category->id] = DB::table('categories')->where('parent_id', $category->id)->get();
            foreach ($sub_categories[$category->id] as $sub_category) {
                $sub_sub_categories[$sub_category->id] = DB::table('categories')->where('parent_id', $sub_category->id)->get();
            }
        }
        return view('admin.categories.create')->with('categories_all', $categories_all)->with('categories', $categories)->with('sub_categories', $sub_categories)->with('sub_sub_categories', $sub_sub_categories);
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
            'name' => 'required|unique:categories,name,null,null,parent_id,' . Input::get('parent_id') . '|max:191',


        ],
            [
                'name.required' => 'من فضلك ادخل  ادخل اسم التصنيف ',
                'name.unique' => 'الاسم موجود بالفعل ',
                'name.max' => 'الاسم يجب الا يزيد عن 191 حرف ',
            ]);


        if ($this->checkCatNameDuplicationConstraint($request->name, $request->parent_id)) {
            Session::flash('alert', 'هذا التصنيف موجود بالفعل ');
            return redirect('categories');
        }

        $categories = new Categories;
        $categories->name = Input::get('name');
        if (Input::get('parent_id')) {
            $categories->parent_id = Input::get('parent_id');
        }

        $categories->save();
//        $arr['name'] = $categories->name;
//        $arr['table_name'] = 'التصنيفات';
//        $arr['type'] = 'اضافة';
//        $arr['row_id'] = $categories->id;
//        LogTimeController::saveLogesTimes($arr);
        // redirect
        Session::flash('message', 'لقد تم ادخال التصنيف بنجاح');
        return redirect('categories');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category_selected = Categories::find($id);

        $categories = Categories::with('children')->whereNull('parent_id')->get();

        // show the edit form and pass the nerd
        return view('admin.categories.edit')->with('categories_all', $categories)->with('category_selected', $category_selected);
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


        request()->validate([
            'name' => 'required|unique:categories,name,null,null,parent_id,' . Input::get('parent_id') . 'max:191',


        ],
            [
                'name.required' => 'من فضلك ادخل  ادخل اسم التصنيف ',
                'name.unique' => 'الاسم موجود بالفعل ',
                'name.max' => 'الاسم يجب الا يزيد عن 191 حرف ',
            ]);

        if ($this->checkCatNameDuplicationConstraint($request->name, $request->parent_id)) {
            Session::flash('alert', 'هذا التصنيف موجود بالفعل ');
            return redirect('categories');
        }
        $categories = Categories::find($id);
        $categories->name = Input::get('name');
        if (Input::get('parent_id')) {
            $categories->parent_id = Input::get('parent_id');
        }
        if (Input::get('parent_id') == "main") {
            $categories->parent_id = null;
        }

        $this->checkCatNameDuplicationConstraint($request->name, $request->parent_id, $id);


        $categories->save();
//        $arr['name'] = $categories->name;
//        $arr['table_name'] = 'التصنيفات';
//        $arr['type'] = 'تعديل';
//        $arr['row_id'] = $categories->id;
//        LogTimeController::saveLogesTimes($arr);
        // redirect
        Session::flash('message', 'لقد تم تعديل التصنيف بنجاح');
        return Redirect::to('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $isAllowedToBeDeleted = false;
        $deleteErrMsg = "";

        $catgerory = Categories::find($id);


        $category_children = Categories::where("parent_id", $id)->get();
        if ($category_children->count() > 0) {
            $isAllowedToBeDeleted = true;
            $deleteErrMsg = "لايمكنك المسح .. التصنيف لديه تصنيفات داخليه";
        }

        if ($this->checkIfCatgHasContent($id)) {
            $isAllowedToBeDeleted = true;
            $deleteErrMsg = "لايمكنك المسح .. التصنيف لديه مواضيع دراسيه";
        }

        if ($isAllowedToBeDeleted) {
            Session::flash('alert', $deleteErrMsg);
            return Redirect::to('categories');
        } else {
//            $arr['name'] = $catgerory->name;
//            $arr['table_name'] = 'التصنيفات';
//            $arr['type'] = 'مسح';
//            $arr['row_id'] = $catgerory->id;
            $catgerory->delete();


//            LogTimeController::saveLogesTimes($arr);
            Session::flash('message', 'لقد تم حذف التصنيف بنجاح');
            return Redirect::to('categories');

        }
    }

    /**
     * @param $catName
     * @param $parentID
     * @param bool $id optional
     * @return bool
     * @todo : a function category name duplication for each parent even if the parent is null
     * @id is optional because it will be used only in case update to prevent selecting the row being updated as duplication
     */

    private function checkCatNameDuplicationConstraint($catName, $parentID, $id = false)
    {


        $row = Categories::where(['name' => $catName, 'parent_id' => $parentID]);
        if ($id) { //in case update , don't get the current row as duplication
            $row->where("id", "!=", $id);
        }
        $result = $row->get();

        if ($result->count() > 0) {
            return true;
        }

        return false;

    }

    private function checkIfCatgHasContent($cat_id)
    {

        $contents = Content::where('category_id', $cat_id)->get();
        if ($contents->count() > 0) {

            return true;
        }
        return false;

    }
}

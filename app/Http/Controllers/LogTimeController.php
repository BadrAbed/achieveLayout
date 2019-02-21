<?php

namespace App\Http\Controllers;

use App\Http\OwnClasses\Permissions;
use App\LogTime;
use Illuminate\Http\Request;
use DateTime;

class LogTimeController extends Controller
{
    /**
     * @param $arry
     * @return bool
     * @todo saveLogesTimesForEveryActionInDataBase
     */
    static function saveLogesTimes($arry)
    {
        $row = new LogTime();
        $row->name = $arry['name'];
        $row->user_id = auth()->id();
        $row->type = $arry['type'];
        $row->table_name = $arry['table_name'];
        $row->row_id = $arry['row_id'];
        $row->save();
        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $logtimes = self::getDetailsOfLogtimesRows();

        return view('admin.logtime.index')->with(compact('logtimes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function logfiltertime(Request $request)
    {
        $timeStart = $request->timeStart;
        $timeEnd = $request->timeEnd;
        $table = array($request->table);

        $arr = self::getDetailsOfLogtimesRows($timeStart, $timeEnd, $table);

        return response($arr);
    }

    static function getDetailsOfLogtimesRows($timeStart = null, $timeEnd = null, $table = null)
    {
        if ($table[0] == "الدروس") {
            $table = array('questions', 'normal_articals', 'sounds', 'vocabulary', 'stretch_articals', 'links', 'content_learning_goals', 'الدروس');
        }
        if ($table[0] == "placement_tests") {
            $table = array('placement_tests', 'placement_test_questions');
        }
        $res = LogTime::orderBy('created_at', 'desc')->get();

        if ($timeStart != null && $timeEnd != null && $table[0] != 'all') {

            $res = LogTime::with('user')->orderBy("id", "desc")->whereBetween('created_at', array($timeStart . '%', date('Y-m-d', strtotime($timeEnd . ' + 1 days')) . '%'))->whereIn('table_name', $table)->get();
        }
        if ($timeStart != null && $timeEnd != null && $table[0] == 'all') {

            $res = LogTime::with('user')->orderBy("id", "desc")->whereBetween('created_at', array($timeStart . '%', date('Y-m-d', strtotime($timeEnd . ' + 1 days')) . '%'))->get();
        }
        if ($timeStart == null && $timeEnd != null && $table[0] == 'all') {
            $res = LogTime::with('user')->orderBy("id", "desc")->where('created_at', '<=', date('Y-m-d', strtotime($timeEnd . ' + 1 days')))->get();

        }
        if ($timeStart == null && $timeEnd != null && $table[0] != 'all') {
            $res = LogTime::with('user')->orderBy("id", "desc")->where('created_at', '<=', date('Y-m-d', strtotime($timeEnd . ' + 1 days')))->whereIn('table_name', $table)->get();

        }
        $arr = [];
        foreach ($res as $data) {
            $table = $data->table_name;
            if ($table == "الدروس") {
                $table = "content";
            }

            $row = \Illuminate\Support\Facades\DB::table($table)->where('id', $data->row_id)->first();

            $name = 'رقم' . $data->row_id;
            if($data->name!='null')
            {
                $name = 'رقم' . $data->row_id.'('.$data->name.')';
            }


            // $content=\App\Content::find($row->content_id);
            if (isset($row->name)) {
                $name = $row->name . ' رقم    ' . '(' . $row->id . ')';
            } elseif (isset($row->content_id) && $table != 'sortinglessons') {
                $content = \App\Content::find($row->content_id);
                $name = ' رقم    ' . '(' . $row->id . ')' . ' للدرس ' . '(رقم' . $row->content_id . ')' . $content->content_name;
            } elseif (isset($row->exam_name)) {
                $name = $row->exam_name . ' رقم    ' . '(' . $row->id . ')';
            } elseif (isset($row->content_name)) {
                $name = $data->name . ' للدرس   ' . $row->content_name . ' رقم    ' . '(' . $row->id . ')';
            } elseif (isset($row->exam_id)) {
                $exam = \App\PlacementTest::find($row->exam_id);
                $name = ' رقم   ' . '(' . $row->id . ')' . $data->desc . ' للامتحان   ' . $exam->exam_name . '(رقم' . $row->exam_id . ')';
            } elseif (isset($row->word)) {
                $word = \App\Vocabulary::find($row->row_id);
                $content = \App\Vocabulary::find($word->content_id);
                $name = ' رقم   ' . '(' . $row->id . ')' . $word->word . ' لدرس   ' . $content->content_name . '(رقم' . $content->id . ')';
            } elseif (isset($row->learing_goals_name)) {
                $goal = \App\LearingGoal::find($row->row_id);

                $name = ' رقم   ' . '(' . $row->id . ')' . $goal->learing_goals_name;
            } elseif (isset($row->lesson_id)) {
                $plan = \App\LessonPlan::find($row->lesson_id);

                $name = 'رقم' . $data->row_id.' (للخطه) '.' رقم   ' . '(' . $plan->id . ')' . $plan->name;
            }
            $userPermission = "طالب";

            if ($data->user->is_permission != \App\Http\OwnClasses\TYPE_OF_USERS_ENUMS::STUDENT) {
                $userPermission = Permissions::getPermissionStringByInt($data->user->is_permission);
            }
            $table_name = \App\Http\OwnClasses\TABLES_NAMES_IN_ARABIC::getTableNameInArabic($data->table_name);
            $arr[] = array('name' => $name, 'user_name' => $data->user->name . '(رقم' . $data->user->id . ')' . '(' . $userPermission . ')', 'type' => $data->type, 'created_at' => $data->created_at, 'table' => $table_name);
        }
        return $arr;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LogTime $logTime
     * @return \Illuminate\Http\Response
     */
    public function show(LogTime $logTime)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LogTime $logTime
     * @return \Illuminate\Http\Response
     */
    public function edit(LogTime $logTime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\LogTime $logTime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LogTime $logTime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LogTime $logTime
     * @return \Illuminate\Http\Response
     */
    public function destroy(LogTime $logTime)
    {
        //
    }


}

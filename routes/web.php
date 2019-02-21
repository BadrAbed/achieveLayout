<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('readtext',function (){
   return view('readText');
});

Route::group(['middleware' => 'createContent'], function () {
    Route::resource('links', 'LinksController')->except([

    ]);
    Route::resource('content', 'ContentController')->except([
        'show'
    ]);
    Route::get("stretch-artical/create/{content_id}", "StretchArtical@create");
    Route::post("stretch-artical/store/{content_id}", "StretchArtical@store");
    Route::get("normal-artical/create/{content_id}", "NormalArtical@create");
    Route::post("normal-artical/store/{content_id}", "NormalArtical@store");
    Route::get('create/links/{content_id}', 'LinksController@create');
    Route::get('create/vocabularys/{content_id}', 'VocabularyController@create');
    Route::post('store/vocabularys/{content_id}', 'VocabularyController@store');

});
Route::group(['middleware' => 'auth'], function () {

    Route::resource('content', 'ContentController')->except([
        "destroy", 'store', 'create', 'edit', 'update', 'index'
    ]);
    Route::get('allQuestions/{content_id}', "QuestionController@allQuestions");
    Auth::routes();
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout'); //Just added to fix issue
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/notAllowed', function () {

        return view('permissions.noPermission');
    });
    Route::get("/admin/content/artical/short/{content_id}/{tab_enum}", "NormalArtical@show")->where(['content_id' => '[0-9]+']);
    Route::get("/admin/content/artical/long/{content_id}/{tab_enum}", "StretchArtical@show")->where(['content_id' => '[0-9]+']);
    Route::get("/admin/content/question/{content_id}/{type}/{tab_enum}", "QuestionController@show")->where(['content_id' => '[0-9]+']);
    Route::get("/admin/content/poll/{content_id}/{type}/{tab_enum}", "PollResultsController@show")->where(['content_id' => '[0-9]+']);
    Route::get('load/numberOfNotification', 'NotificationsController@numberOfNotification');
    Route::post("add/issues/{content_id}/{tab_num}", "IssuesController@store");
    Route::get("view/issues/{content_id}", "IssuesController@view");
    Route::post("edit/issues/{content_id}/{tab_num}", "IssuesController@update");
});


Route::group(['middleware' => 'public'], function () {

    Route::resource('content', 'ContentController')->except([
        "destroy", 'show', 'create', 'store', 'index'
    ]);
    Route::get('Editor/feedback/{id}', 'EditorController@feedback');
    Route::get('ViewContentFromSpecificDateToSpecificDate/{user_id?}', 'ContentController@toViewContentFromSpecificDateToSpecificDate');


    Route::get('/content/{id}/delete', 'ContentController@destroy');
    Route::get('ajax/content/getAll', 'ContentController@ajaxGetAllContent');
    Route::get('getctag', ['as' => 'getctag', 'uses' => 'ContentController@getctag']);
    Route::get('incomplete', ['as' => 'incomplete', 'uses' => 'ContentController@incomplete']);
    Route::get('viewpag', ['as' => 'viewpag', 'uses' => 'ContentController@showbynumber']);

    Route::get('filtercountry', ['as' => 'filtercountry', 'uses' => 'ContentController@filtercountry']);
    Route::get('filtercat', ['as' => 'filtercat', 'uses' => 'ContentController@filtercat']);
    Route::get('filtergrade', ['as' => 'filtergrade', 'uses' => 'ContentController@filtergrade']);
//Questions


    Route::resource('stretch-artical', 'StretchArtical')->except([
        'show', "create", "store"
    ]);

    // show is reserved to another routes written bello
    Route::resource('normal-artical', 'NormalArtical')->except([
        'show', "create", "store"
    ]);

    Route::resource('links', 'LinksController')->except([
        "create", "store"
    ]);

    Route::resource('vocabularys', 'VocabularyController')->except([
        "create", "store"
    ]);
    Route::get('show_voc_content/{content_id}', ['as' => 'show_voc_content', 'uses' => 'VocabularyController@show_voc_content']);
    Route::get('/vocabularys/{id}/delete', 'VocabularyController@destroy');

    Route::get('delteseleteccontent', ['as' => 'delteseleteccontent', 'uses' => 'ContentController@deleteMultipleContents']);
//Poll

//student content routes

////admin content routes


});


Route::group(['middleware' => 'admin'], function () {

    Route::get('createquestion/{type}/{content_id}', ['as' => 'createquestion', 'uses' => 'QuestionController@create']);
    Route::post('createquestion/store/{content_id}', "QuestionController@store");
    // Route::post('addationQuestion/store/{content_id}', "QuestionController@store");
    // Route::get('addationQuestion/{content_id}', "QuestionController@create");
    Route::resource('categories', 'CategoriesController')->except([
        'destroy'
    ]);

    Route::get("categories/{id}/delete", "CategoriesController@destroy");


    // show is reserved to another routes written bello


    Route::resource('country', 'CountryController');

    Route::get('/country/{id}/delete', 'CountryController@destroy');

    Route::resource('education-level', 'EducationLevelController');

    Route::get('/education-level/{id}/delete', 'EducationLevelController@destroy');


    //Route::get('addSortingEduLevels', 'SortingEducationLevels@addSortingEduLevels');


//content


//learing goal

    Route::get('creategoal', ['as' => 'creategoal', 'uses' => 'LearingGoalController@create']);
    Route::post('creategoal', ['as' => 'creategoal', 'uses' => 'LearingGoalController@store']);
    Route::get('showgoal', ['as' => 'showgoal', 'uses' => 'LearingGoalController@index']);
    Route::get('/learinggoal/{id}/delete', 'LearingGoalController@destroy');
    Route::get('/learinggoal/{id}/edit', 'LearingGoalController@edit');
    Route::put('updategoal', ['as' => 'updategoal', 'uses' => 'LearingGoalController@update']);


    Route::resource('users', 'UsersController');
    Route::get('/users/{id}/delete', 'UsersController@destroy');
    Route::get('/getRelatedContentsForUsers/{id}', 'UsersController@getRelatedContentsForUsers');
    Route::get('/add/Student', 'UsersController@userStudent');
    Route::post('/add/Student', 'UsersController@addUserByAdmin');
    Route::get('/addSchool', 'UsersController@addSchoolCreate');
    Route::get('viewSpecificUsers/{user_enum}', 'UsersController@viewSpecificUsers');
    Route::get('/viewAllSchools', 'UsersController@indexAllSchools');
    Route::post('/addSchool', 'UsersController@addSchoolStore');
    Route::get('SoftDeleteSchool/{school_id}', 'SchoolDashboardController@SoftDeleteSchool');
    Route::get('SuspendedSchools', 'SchoolDashboardController@SuspendedSchools');
    Route::get('ForceDeleteSchool/{school_id}', 'SchoolDashboardController@ForceDeleteSchool');
    Route::get('RestoreDeleteSchool/{school_id}', 'SchoolDashboardController@RestoreDeleteSchool');
    Route::get('viewSchool/{id}', 'SchoolDashboardController@viewSchool');
    Route::get('editSchool/{id}', 'SchoolDashboardController@editSchool');
    Route::post('editSchool/{id}', 'SchoolDashboardController@updateSchool');


    /**
     * If student , redirect to student controller
     * if admin , redirect to admin controller
     */
    //Route::get('/home', 'HomeController@index')->name('home');
//    Route::get('/home', function () {
//
//
//        if (Permissions::STUDENT_PERMISSION_ENUM == auth()->user()->is_permission) {//if student
//            return redirect()->action("StudentDashboard@index");
//        } else {
//
//            return redirect()->action("MangmentDashboard@index");
//
//        }
//
//    })->name('home');


// start voice sentences routes

    Route::group(["prefix" => "voiceSentences"], function () {
        //the type parameter below will specify if we need to show naviation buttons of add or edit

        Route::get("create/{type}/{tn}/{articleID}", "VoiceReaderController@startProcessingSentencesWithAudio")->where([
            "audioID" => "[0-9]+",
            "tn" => "[A-Z]+"]);

        Route::get("finalize/{type}/{audioId}/{tn}", "VoiceReaderController@finalizeProcessingSentencesWithAudio")->where([
            "audioId" => "[0-9]+",
            "tn" => "[A-Z]+"]);

        Route::get("listen/{type}/{audioId}/{tn}", "VoiceReaderController@listen")->where([
            "audioId" => "[0-9]+",
            "tn" => "[A-Z]+"]);
    });

    Route::group(["prefix" => "voiceSentences/ajax"], function () {
        Route::get("items/{audioID}", "VoiceReaderController@getAllSentencesOfSpecificAudio");
        Route::post("addItem/{audioId}/{contentId}", "VoiceReaderController@addNewSoundSentenceRow");
        Route::post("editItem/{audioId}/{contentId}", "VoiceReaderController@editSoundSentenceRow");
        Route::post("deleteItem/{audioId}/{contentId}", "VoiceReaderController@deleteSoundSentenceRow");
    });


    //LessonsPlan routes
    Route::post('addplan', ['as' => 'addplan', 'uses' => 'LessonPlanController@store']);//add plan
    Route::get('viewplans', ['as' => 'viewplans', 'uses' => 'LessonPlanController@index']);//view plans
    Route::get('viewSpecificPlan', ['as' => 'viewSpecificPlan', 'uses' => 'LessonPlanController@show']);//viewSpecificPlan
    Route::get('deletePlan', ['as' => 'deletePlan', 'uses' => 'LessonPlanController@destroy']);//
    Route::post('updatePlan', ['as' => 'updatePlan', 'uses' => 'LessonPlanController@update']);
    Route::get('updatePlan', ['as' => 'updatePlan', 'uses' => 'LessonPlanController@edit']);
    Route::get('planFilterCountry', ['as' => 'planFilterCountry', 'uses' => 'LessonPlanController@filtercountry']);//planFilterCountry
    Route::get('planFilterGrade', ['as' => 'planFilterGrade', 'uses' => 'LessonPlanController@filtergrade']);//planFilterGrade
    Route::get('get_sub_garde', ['as' => 'get_sub_garde', 'uses' => 'LessonPlanController@subgrade']);


//SortingPlan routes
    Route::get('viewPlanLessons', ['as' => 'viewPlanLessons', 'uses' => 'SortinglessonController@index']);//viewPlanLessons
    Route::get('addLessonPlan', ['as' => 'addLessonPlan', 'uses' => 'SortinglessonController@store']);//addLessonPlan
    Route::get('deletePlanSpecificLesson', ['as' => 'deletePlanSpecificLesson', 'uses' => 'SortinglessonController@destroy']);//deletePlanSpecificLesson
    Route::get('editPlanSpecificLesson', ['as' => 'editPlanSpecificLesson', 'uses' => 'SortinglessonController@edit']);// editPlanSpecificLesson
    Route::get('updatePlanSpecificLesson', ['as' => 'updatePlanSpecificLesson', 'uses' => 'SortinglessonController@update']);//updatePlanSpecificLesson


    //static routing
    Route::view("/student", "admin.dashboards.student");
    Route::view("/admin", "admin.dashboards.admin");
    Route::get('/', 'MangmentDashboard@index');


//logtime

    Route::get('logtime', ['as' => 'logtime', 'uses' => 'LogTimeController@index']);
    Route::get('logfiltertime', ['as' => 'logfiltertime', 'uses' => 'LogTimeController@logfiltertime']);


// end voice sentences routes


//admin dashboard


//dictionary

    Route::prefix("dictionary")->group(function () {

        Route::get('create/word', 'DictionaryController@create');
        Route::get('allWords', 'DictionaryController@index');
        Route::post('store/word', 'DictionaryController@store');
        Route::get('view/{id}', 'DictionaryController@view');
        Route::get('{id}/edit', 'DictionaryController@edit');
        Route::post('{id}/edit', 'DictionaryController@update');
        Route::get('{id}/delete', 'DictionaryController@delete');
        Route::get('ajax/getAll', 'DictionaryController@ajaxAllWords');


    });
//studentPlacementTest

    Route::prefix("admin")->group(function () {

        Route::resource("placement_test", "PlacementTest")->except([
            "destroy"
        ]);
        Route::get("ajaxAllPlacementTests", "PlacementTest@ajaxAllPlacementTests");
        Route::get('/placement_test/{id}/delete', 'PlacementTest@destroy');

        Route::get("placement_test_questions/create/{placement_test_id}", "PlacementTestQuestions@create");
        Route::post("placement_test_questions/{placement_test_id}", "PlacementTestQuestions@store");


        Route::get("placement_test_questions/show/{question_id}", "PlacementTestQuestions@show");
        Route::post("placement_test_questions/update/{question_id}", "PlacementTestQuestions@update");
        Route::get("placement_test_questions/edit/{question_id}", "PlacementTestQuestions@edit");
        Route::get("placement_test_questions/delete/{question_id}", "PlacementTestQuestions@destroy");


    });
//    Route::prefix("Student")->group(function () {

//    });
    Route::get('test', function () {

        return view('admin.educationLevel.sortingEduLevels');
    });
});

Route::group(['middleware' => 'student'], function () {
    Route::prefix("Student")->group(function () {

        Route::get("placement_test/instruction/{placement_id}", "StudentPlacementTest@instruction");
        Route::get("placement_test/feedback", "StudentPlacementTest@feedback");

        Route::post("AnswerPlacementTest/{grade_id}/{quest_id}", "StudentPlacementTest@store");
        Route::get("placement_test/{grade_id}", "StudentPlacementTest@viewPlacementTestToStudent");
        Route::get("placement_test/feedback/LessonPlan", "StudentDashboard@feedbackForLessonPlan");
        Route::get("noLessonPlanYat", "StudentDashboard@noLessonPlanYat");
        Route::get("next/placement_test", "CommonStudentLessonsProcesses@DeleteCurrentLessonPlanAndUpdateStatusOfLessonPlanInHistoryTableForUser");

    });


    Route::get("/student/content/artical/short/{content_id}/{tab_enum}", "NormalArtical@show")->where(['content_id' => '[0-9]+'])->name("student_short_article");
    Route::get("/student/content/artical/long/{content_id}/{tab_enum}", "StretchArtical@show")->where(['content_id' => '[0-9]+'])->name("student_long_article");
    Route::get("/student/content/question/{content_id}/{type}/{tab_enum}", "QuestionController@show")->where(['content_id' => '[0-9]+'])->name("student_both_short_and_long_question");
    Route::get("/student/content/poll/{content_id}/{type}/{tab_enum}", "PollResultsController@show")->where(['content_id' => '[0-9]+'])->name("student_both_short_and_long_poll");

    Route::get("/student/content/next_lesson/{content_id}", "CommonStudentLessonsProcesses@navigateStudentToTheNextLesson")->where(['content_id' => '[0-9]+'])->name("student_next_lesson");


    Route::get("/student/content/last_student_lesson_working_on", "CommonStudentLessonsProcesses@navigateToCurrentLesson")->name("last_student_lesson_working_on");


    Route::get("test/{content_id}", "CommonStudentTabsProcesses@get_lesson_all_tabs_statuses");


    Route::get("student_next_tab_button/{content_id}/{tab_enum}", "CommonStudentTabsProcesses@nextTabButtonProcess")->where(['content_id' => '[0-9]+']);
    Route::get("exception_mark_tab_as_completed_and_navigate_to_next_lesson/{content_id}/{tab_enum}", "CommonStudentLessonsProcesses@exception_mark_tab_as_completed_and_navigate_to_next_lesson")->where(['content_id' => '[0-9]+', "tab_enum" => '[0-9]+'])->name("exception_mark_tab_as_completed_and_navigate_to_next_lesson");

    Route::get("studentLessons", "StudentDashboard@list_of_lessons");
    Route::get('studentDashboard', 'StudentDashboard@index');

    Route::post('answerpoll', ['as' => 'answerpoll', 'uses' => 'PollResultsController@store']);

    Route::get('reattemptQuestions/{content_id}/{type}', "QuestionController@reattemptQuestionForUserInSpecificContent");
    // Route::get("/student/markTabAsCompleted/{content_id}/{tab_enum}", "ContentController@markTabAsCompleted")->where(['content_id' => '[0-9]+', 'tab_enum' => '[0-9]+']);
//    Route::get('student/LessonTabMarkTabAsCompleted/{content_id}/{tab_enum}', ['uses' => 'ContentController@markTabAsCompleted']);
    Route::post('addanswer', ['as' => 'addanswer', 'uses' => 'QuestionController@index']);
});

Route::group(['middleware' => 'editor'], function () {

    Route::get('Editor/review/{id}', 'ContentFollowStatusController@reviewForEditor');
    Route::get('Editor/under/review', 'EditorController@viewUnderReview');
    Route::get('Editor/publishedLessons', 'EditorController@publishedLessons');
    Route::get('Editor/refusedLessons', 'EditorController@refusedLessons');
    Route::get('Editor/home', 'EditorController@index');
    Route::get('Editor/work/onIssues/{id}', 'EditorController@WorkOnIssues');
    Route::get('Editor/close/Issues/{id}', 'EditorController@CloseTheIssues');
    Route::get('Editor/resendLessonFromEditorToReviewer/{id}', 'ContentFollowStatusController@resendLessonFromEditorToReviewer');

});
Route::group(['middleware' => 'reviewer'], function () {

    //
    Route::get('Reviewer/sendToCreateQuestions/{id}', 'ContentFollowStatusController@sendToCreateQuestions');
    Route::get('Reviewer/ResendToLangReview/{id}', 'ContentFollowStatusController@sendToLangReviewer');
    Route::get('Reviewer/refused/{id}', 'ContentFollowStatusController@refusedFromEditor');
    Route::get('Reviewer/under/review', 'ReviewerController@viewUnderReview');
    Route::get('Reviewer/feedbackForReviewer/{id}', 'ReviewerController@feedbackForReviewer');

    Route::get('Reviewer/publishedLessons', 'ReviewerController@publishedLessons');
    Route::get('Reviewer/refusedLessons', 'ReviewerController@refusedLessons');
    Route::get('Reviewer/resendingLessons', 'ReviewerController@resendingLessons');
    Route::get('Reviewer/home', 'ReviewerController@index');
    Route::get('Reviewer/lessons', 'ReviewerController@lessons');
    Route::get('Reviewer/Assign/Lessons/{id}', 'ReviewerController@AssignLessons');
    Route::get('Reviewer/AjaxLessons', 'ReviewerController@AjaxLessons');
    Route::get('Reviewer/MyLessons', 'ReviewerController@AjaxMyLessons');
    Route::get('Reviewer/MyLessons/view', 'ReviewerController@MyLessonsView');

});


Route::group(['middleware' => 'langReviewer'], function () {

    Route::get('LangReviewer/AllLessons/view', 'LangReviewerController@AllLessonsView');
    Route::get('LangReviewer/AjaxAllLessons', 'LangReviewerController@AjaxAllLessons');
    Route::get('LangReviewer/AjaxMyLessons', 'LangReviewerController@AjaxMyLessons');
    Route::get('LangReviewer/myLessonsView', 'LangReviewerController@myLessonsView');
    Route::get('LangReviewer/assignLessonToAudit/{id}', 'LangReviewerController@assignLessonToAudit');
    Route::get('LangReviewer/LangReviewerRefuse/{id}', 'ContentFollowStatusController@LangReviewerRefuse');
    Route::get('LangReviewer/LangReviewerSendToPublisher/{id}', 'ContentFollowStatusController@LangReviewerSendToPublisher');
    Route::get('LangReviewer/resendingLessons', 'LangReviewerController@resendingLessons');
});

Route::group(['middleware' => 'publisher'], function () {

    Route::get('publisher/AllLessons/view', 'PublisherController@AllLessonsView');
    Route::get('publisher/AjaxAllLessons', 'PublisherController@AjaxAllLessons');
    Route::get('publisher/AjaxMyLessons', 'PublisherController@AjaxMyLessons');
    Route::get('publisher/myLessonsView', 'PublisherController@myLessonsView');
    Route::get('publisher/assignLessonToPublisher/{id}', 'PublisherController@assignLessonToPublisher');
    Route::get('publisher/publish/{id}', 'ContentFollowStatusController@publish');
    Route::get('publisher/refused/{id}', 'ContentFollowStatusController@PublisherRefuse');
    Route::get('publisher/resendingLessons', 'PublisherController@resendingLessons');
});


Route::group(['middleware' => 'questionEditor'], function () {


    Route::get('QuestionsEditor/AjaxAllLessons', "QuestionsEditorController@AjaxAllLessons");
    Route::get('QuestionsEditor/index', "QuestionsEditorController@index");
    Route::get('QuestionsEditor/home', "QuestionsEditorController@home");
    Route::get('QuestionsEditor/AssignLessonsToQuestionsEditor/{id}', "QuestionsEditorController@AssignLessonsToQuestionsEditor");
    Route::get('QuestionsEditor/MyLessons', "QuestionsEditorController@MyLessons");
    Route::get('QuestionsEditor/MyLessonsView', "QuestionsEditorController@MyLessonsView");
    //question
    Route::get('QuestionsEditor/create/Questions/{type}/{content_id}', "QuestionsEditorController@createQuestions");
    Route::post('QuestionsEditor/store/Questions/{type}/{content_id}', "QuestionsEditorController@storeQuestions");
    Route::get('QuestionsEditor/SendToQuestionReviewer/{content_id}', "ContentFollowStatusController@SendToQuestionReviewer");
    Route::get('QuestionsEditor/resendQuestionsToQuestionsReviewer/{content_id}', "ContentFollowStatusController@resendQuestionsToQuestionsReviewer");
    Route::get('QuestionsEditor/ResendingQuestions', "QuestionsEditorController@ResendingQuestions");
//    Route::post('addationQuestion/store/{content_id}', "QuestionController@store");


});
Route::get('editQuestion/{id}', "QuestionController@edit")->middleware('questionEditorRoutes:reviewerAndEditor');
Route::post('editQuestion/{id}', "QuestionController@update")->middleware('questionEditorRoutes:reviewerAndEditor');
Route::get('deleteQuestion/{id}', "QuestionController@destroy")->middleware('questionEditorRoutes:reviewerAndEditor');
Route::group(['middleware' => 'questionReviewer'], function () {
    Route::get('QuestionsReviewer/AjaxAllLessons', "QuestionsReviewerController@AjaxAllLessons");
    Route::get('QuestionsReviewer/index', "QuestionsReviewerController@index");
    Route::get('QuestionsReviewer/home', "QuestionsReviewerController@home");
    Route::get('QuestionsReviewer/AssignLessonsToQuestionsReviewer/{id}', "QuestionsReviewerController@AssignLessonsToQuestionsReviewer");
    Route::get('QuestionsReviewer/MyLessons', "QuestionsReviewerController@MyLessons");
    Route::get('QuestionsReviewer/MyLessonsView', "QuestionsReviewerController@MyLessonsView");
    Route::get('QuestionsReviewer/SendToLangReview/{id}', 'ContentFollowStatusController@sendToLangReviewer');
    Route::get('QuestionsReviewer/refusedQuestions/{id}', 'ContentFollowStatusController@refusedQuestions');
    Route::get('QuestionsReviewer/ResendingQuestions', 'QuestionsReviewerController@ResendingQuestions');

});


Route::group(['middleware' => 'schoolsAdmins'], function () {
    Route::get('SchoolDashboard', 'SchoolDashboardController@SchoolDashboard')->middleware('schoolsAdmins:school');
    Route::get('SchoolAddStudent', 'SchoolDashboardController@SchoolAddStudent')->middleware('schoolsAdmins:school');
    Route::post('SchoolStoreStudent', 'SchoolDashboardController@SchoolStoreStudent')->middleware('schoolsAdmins:school');
    Route::get('getCSVFileForStudent', 'SchoolDashboardController@getCSVFileForStudent')->middleware('schoolsAdmins:school');
    Route::post('uploadCSVFileFormSchool', 'SchoolDashboardController@uploadCSVFileFormSchool')->middleware('schoolsAdmins:school');
    Route::get('downloadEmptyCSVFile', 'SchoolDashboardController@downloadEmptyCSVFile')->middleware('schoolsAdmins:school');
    Route::get('FollowStudentInSchool/{student_id}', 'SchoolDashboardController@FollowStudentInSchool')->middleware('schoolsAdmins:school');
    Route::get('downloadLevelsCSVFile', 'SchoolDashboardController@downloadLevelsCSVFile')->middleware('schoolsAdmins:school');
    Route::get('deleteStudent/{id}', 'SchoolDashboardController@deleteStudent')->middleware('schoolsAdmins:school');
    Route::get('SchoolEditStudent/{id}', 'SchoolDashboardController@SchoolEditStudent')->middleware('schoolsAdmins:school');
    Route::post('SchoolEditStudent/{id}', 'SchoolDashboardController@SchoolUpdateStudent')->middleware('schoolsAdmins:school');
    Route::get('SchoolAllStudent', 'SchoolDashboardController@SchoolAllStudent')->middleware('schoolsAdmins:school');

});

//});
Route::get('/loginSchool',
    'SchoolController@showLoginForm')->name('admin.login');
Route::post('/loginSchool', 'SchoolController@login')->name('admin.login.submit');
Route::get('/logoutSchool', 'SchoolController@logout');

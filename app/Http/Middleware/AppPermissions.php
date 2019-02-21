<?php

namespace App\Http\Middleware;

use App\Http\OwnClasses\Permissions;
use Closure;

class AppPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $module)
    {


        //please not that these functions are the audio sentences functions and it holds both create and edit , so Mr Ahmed requested to be opened for both add and edit permissions
        $listOfControllerFunction = ["ajaxAllPlacementTests","reattemptQuestionForUserInSpecificContent", "feedbackForLessonPlan", "instruction", "viewPlacementTestToStudent", "checkIfStudentPlacementTest", "ajaxGetAllContent", "deleteMultipleContents", "studentEachLessonAccess", "checkIfUserAllowedToAccessThisLesson", "assignLessonPlanToStudent", "getTabEnumBySpecificContentIdOnSpecificLessonPlan", "checkIfTabHasBeenCompletedBefore", "markTabAsCompleted", "index", "create", "store", "show", "edit", "update", "destroy", "incomplete", "show_voc_content", "createAddation", "startProcessingSentencesWithAudio", "addNewSoundSentenceRow", "getAllSentencesOfSpecificAudio", "editSoundSentenceRow", "deleteSoundSentenceRow", "finalizeProcessingSentencesWithAudio", "listen", "default", "filtercountry", "filtergrade", "getctag"];
        $currentAction = explode("@", $request->route()->getActionName());
        $currentMethod = $currentAction[1];//getting the controller function

        if (!in_array($currentMethod, $listOfControllerFunction)) {//if the function isn't between the list of defined functions , trigger error
            abort(403, 'Permissions : Undefined Method');
        }

        $permission = new Permissions($module);


        switch ($currentMethod) {

            case "index":
            case "incomplete"://like showing the incomplete content.
            case "default":///the same as show index
            case "filtercountry":
            case "filtergrade":
                //view
                if (!$permission->hasViewPermission()) {
                    return response(view("permissions.noPermission"));
                }
                break;

            case "create":
            case "createAddation"://create question of the second stretch article , they named it like that
                //create form , add
                if (!$permission->hasAddPermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;
            case "deleteMultipleContents"://create question of the second stretch article , they named it like that
                //create form , add
                if (!$permission->hasDeletePermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;
            case "store":
                //add from create form , add
                if (!$permission->hasAddPermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;
            case "show":
            case "show_voc_content"://Badr route for fetch vocabulary of specific content

                //view specific item
                if (!$permission->hasViewPermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;
            case "edit":
                //edit form , edit
                if (!$permission->hasEditPermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;
            case "update":
                //edit from create form , edit
                if (!$permission->hasEditPermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;
            case "destroy":
                //delete
                if (!$permission->hasDeletePermission()) {
                    return response(view("permissions.noPermission"));
                }

                break;


            //please not that these functions are the audio sentences functions and it holds both create and edit , so Mr Ahmed requested to be opened for both add and edit permissions
            case "startProcessingSentencesWithAudio":
            case "checkIfStudentPlacementTest":
            case"addNewSoundSentenceRow":
            case"instruction":
            case"feedbackForLessonPlan":
            case"viewPlacementTestToStudent":
            case"reattemptQuestionForUserInSpecificContent":
            case"ajaxAllPlacementTests":

            case "getAllSentencesOfSpecificAudio":
            case "editSoundSentenceRow":
            case "deleteSoundSentenceRow":
            case "finalizeProcessingSentencesWithAudio":
            case "listen":
            case "getctag"://get categories by ajax request in content add and edit
            case "markTabAsCompleted":
            case "checkIfTabHasBeenCompletedBefore":
            case "getTabEnumBySpecificContentIdOnSpecificLessonPlan":
            case "checkIfUserAllowedToAccessThisLesson":
            case "assignLessonPlanToStudent":
            case"studentEachLessonAccess":
            case"ajaxGetAllContent":
                if (!$permission->hasEditPermission() && !$permission->hasAddPermission()) {//it must has at least either add or edit permission to editor
                    return response(view("permissions.noPermission"));
                }

                break;


        }

        return $next($request);
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: youhana.sobhy
 * Date: 5/13/2018
 * Time: 9:07 AM
 */

namespace App\Http\OwnClasses;

use \App\User;
use \App\User_Linked_Countries_Permissions;
use \App\User_Linked_Grades_Permissions;


Class SetRules
{
    /**
     *
     * this app has 3 different permissions ,  a permission of access  a specific section or not
     * has permission or not for the navigation buttons like add , edit or delete
     * has permission for add , edit , delete , view of specific country or grade
     * so we solved that by generating an object has the following functions :
     *  1- hasAddPermission / hasEditPermission / hasDeletePermission / hasViewPermission => boolean to be used in restrict either accessing a specific page (to be used in middelwares) or hide and show navigation buttons
     *  2- allowedCountries : array to be used either in viewing specific content countries or not , and to be used in forcing specific list of countries in case add / update content
     *  3- allowedGrades : array to be used either in viewing specific content countries or not , and to be used in forcing specific list of countries in case add / update content
     * permission : like , admin , user ,etc..
     * currentModule : like users , lesson goals
     *
     */

    protected $hasAddPermission = false;
    protected $hasEditPermission = false;
    protected $hasDeletePermission = false;
    protected $hasViewPermission = false;
    protected $hasPublishPermission = false; //related to content and lesson plans

    function rules($module, $permission)
    {


        switch ($module) {


            case "users":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;

                        break;

                    case "leader":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;

                        break;

                    case "editor":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "student":

                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                }

                break;


            case "content":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;
                        $this->hasPublishPermission = false;

                        break;

                    case "leader":
                        $this->hasAddPermission = true;//has add for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasEditPermission = true;//has edit for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasDeletePermission = true;//has delete for specific countries or grades  , so we will allow access but we will resrict the choice in their controllers
                        $this->hasViewPermission = true;//has view for specific countries or grades , , so we will allow access but we will resrict the choice in their controllers
                        $this->hasPublishPermission = false;//has publish for specific countries or grades , so we will allow access but we will resrict the choice in their controllers

                        break;

                    case "editor":
                        $this->hasAddPermission = true;//has add for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasEditPermission = true;//has edit for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;
                        $this->hasPublishPermission = false;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = true;//has edit for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;
                        $this->hasPublishPermission = false;

                        break;

                    case "student":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;
                        $this->hasPublishPermission = true;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;
                        $this->hasPublishPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = true;//has edit for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;
                        $this->hasPublishPermission = false;

                        break;

                }
                break;


            case "lesson_plans":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;
                        $this->hasPublishPermission = false;

                        break;

                    case "leader":
                        $this->hasAddPermission = true;//has add for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasEditPermission = true;//has edit for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasDeletePermission = true;//has delete for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasViewPermission = true;//has view for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasPublishPermission = true;//has publish for specific countries or grades , so we will allow access but we will resrict the choice in their controllers

                        break;

                    case "editor":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = true;//has edit for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;//has view for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasPublishPermission = false;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;//has view for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasPublishPermission = false;

                        break;

                    case "student":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;
                        $this->hasPublishPermission = false;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;
                        $this->hasPublishPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;//has view for specific countries or grades , so we will allow access but we will resrict the choice in their controllers
                        $this->hasPublishPermission = true;//has publish for specific countries or grades , so we will allow access but we will resrict the choice in their controllers

                        break;

                }
                break;


            case "grades":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;

                        break;

                    case "leader":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "editor":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "student":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                }
                break;


            case "categories":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;

                        break;

                    case "leader":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "editor":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "student":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                }
                break;


            case "learning_goals":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;

                        break;

                    case "leader":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "editor":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                    case "student":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = true;

                        break;

                }
                break;


            case "country":

                switch ($permission) {

                    case "admin":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = true;
                        $this->hasDeletePermission = true;
                        $this->hasViewPermission = true;

                        break;

                    case "leader":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "editor":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "reviewer":
                        $this->hasAddPermission = true;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "student":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "parent":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                    case "audit":
                        $this->hasAddPermission = false;
                        $this->hasEditPermission = false;
                        $this->hasDeletePermission = false;
                        $this->hasViewPermission = false;

                        break;

                }
                break;


        }


    }


}

Class Permissions Extends SetRules
{
    protected $currentModule;
    protected $permission;
    protected $allowedCountries;
    protected $allowedGrades;
    public const EnglishPermissionsList = array("0" => "admin", "1" => "leader", "2" => "editor", "3" => "reviewer", "4" => "student", "5" => "parent", "6" => "audit", "7" => "publisher", '8' => 'questionCreator', '9' => 'questionsReviewer');
    public const PermissionsList = array("0" => "الاداره", "1" => "رئيس", "2" => "محرر", "3" => "مراجع", "6" => "مصحح لغوي", "7" => "ناشر", "8" => 'محرر اسئلة', "9" => 'مراجع اسئلة');
    public const permissionListForleader = array("2" => "محرر", "3" => "مراجع", "6" => "مصحح لغوي", "7" => " ناشر", "8" => 'محرر اسئلة', "9" => 'مراجع اسئلة');

    public const ModuleNames = ["users", "content", "lesson_plans", "grades", "categories", "learning_goals", "country"];

    public const STUDENT_PERMISSION_ENUM = 4;


    function __construct(string $moduleName)
    {

        if (!auth()->check()) {//if not logged in
            abort(403, 'Permissions : You have no authorize'); //Fire last error if the developer used this class in a place before validating user login
        }

        if (!in_array(strtolower($moduleName), self::ModuleNames)) {//check if provided module name is exisitng within our whitelist array
            abort(403, 'Permissions : Undefined module name'); //Fire last error if the developer used this class in a place before validating user login
        }


        $this->currentModule = $moduleName;
        $this->permission = self::getPermissionStringByInt(auth()->user()->is_permission, true);

        $this->allowedCountries = $this->addCountryToObject();//add the allowed countries to  an object property
        $this->allowedGrades = $this->addGradeToObject(); //add the allowed countries to an object property

        $this->rules($this->currentModule, $this->permission);//set the permissions rules , fill the whole properties

    }


    function addCountryToObject(): array
    {//must return array to be selected in select boxes of add
        //return array of allowed countries for this user

        $userAttachedCountries = User_Linked_Countries_Permissions::where("user_id", auth()->id())->get();
        $countriesFinalArr = [];
        foreach ($userAttachedCountries as $eachCountryObj) {
            $countriesFinalArr[] = ["id" => $eachCountryObj->getRelatedCountry->id, "name" => $eachCountryObj->getRelatedCountry->name];
        }

        return $countriesFinalArr;
    }


    function addGradeToObject(): array
    {//must return array to be selected in select boxes of add
        //return array of allowed grades for this user

        $userAttachedEducationLevels = User_Linked_Grades_Permissions::where("user_id", auth()->id())->get();
        $educationLevelFinalArr = [];
        foreach ($userAttachedEducationLevels as $eachLevelObj) {
            $educationLevelFinalArr[] = ["id" => $eachLevelObj->getRelatedLevel->id, "name" => $eachLevelObj->getRelatedLevel->name];
        }


        return $educationLevelFinalArr;
    }


    public static function getPermissionStringByInt(int $int, $getEnglishString = false)
    {
        if (auth()->user()->is_permission != TYPE_OF_USERS_ENUMS::STUDENT) {
            if (@!self::PermissionsList[$int]) {//if the inserted number is not defined.
                abort(403, 'Permissions : Undefined permission'); //Fire error if the module name is incorrect
            }
        }
        if ($getEnglishString) {
            return self::EnglishPermissionsList[$int];
        }
        return self::PermissionsList[$int];

    }


    public function getAllowedCounteries()
    {
        return $this->allowedCountries;

    }

    public function getAllowedGrades()
    {
        return $this->allowedGrades;
    }

    public function hasAddPermission()
    {
        return $this->hasAddPermission;
    }

    public function hasEditPermission()
    {
        return $this->hasEditPermission;
    }

    public function hasDeletePermission()
    {
        return $this->hasDeletePermission;
    }

    public function hasViewPermission()
    {
        return $this->hasViewPermission;
    }


}





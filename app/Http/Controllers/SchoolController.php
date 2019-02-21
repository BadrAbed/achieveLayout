<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Support\Facades\Auth;

class SchoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:school', ['except' => ['logout']]);
    }

    public function showLoginForm()
    {
        return view('schools.login');
    }

    public function login(Request $request)
    {


        // Validate the form data
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $school = School::where('email', $request->email)->first();

        if ($school) {

            $AcountEndDate = new DateTime($school->end_on);
            $Todaydate = new DateTime(date("Y-m-d h:i:sa"));
            if ($AcountEndDate < $Todaydate) {
                return redirect()->back()->withErrors(['Account not Activation ']);
            }
        }
        if (Auth::guard('school')->attempt(['email' => $request->email, 'password' => $request->password])) {

            // if successful, then redirect to their intended location
            return redirect('SchoolDashboard');
        }

        // if unsuccessful, then redirect back to the login with the form data
        return redirect()->back()->withErrors(['email or password not correct ']);
    }


    public function logout()
    {
        Auth::guard('school')->logout();
        return redirect('/login');
    }
}

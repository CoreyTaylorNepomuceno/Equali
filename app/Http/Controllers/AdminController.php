<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function ShowAdminOverview()
    {

        $recentApplicants = User::where('role', 'Student')
        ->with('admissionExam')
        ->latest('created_at')
        ->limit(5)
        ->get();
        

        $user = User::where('role', 'Student')->get();

        return view('admin.dashboard-overview', compact('recentApplicants', 'user'));
    }

    function ShowInterview(Request $request){
        $userCount = User::all();
        $users = User::where('role', 'Student')->where('status', 'Ready For Interview')
        ->with('qualifiedStudent')
        ->doesntHave('studentInfo')
        ->latest('created_at');

        $users = $users->paginate(10);
        return view('admin.dashboard-view-interview', compact( 'users', 'userCount'));
    }
    
    

   
}

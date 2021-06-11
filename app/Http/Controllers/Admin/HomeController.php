<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\models\Request;
use App\models\Video;
use App\User;

class HomeController extends Controller
{
    public function index()
    {
        $requests = Request::orderBy('created_at','asc')->orderBy('status','desc')->with('video')->paginate(2, ['*'], 'requests');
        $videos = Video::where('active_summary',"!=","NULL")->orderBy('created_at','desc')->with('summary')->paginate(2, ['*'], 'videos');
        return view("admin.dashboard",compact('requests','videos'));
    }

    public function manageUsers()
    {
        $users = User::all();
        return view("admin.manage_users",compact('users'));
    }

    public function deleteUser($id)
    {
        $user = User::where('id', $id);
        $user->delete();
        return redirect()->back()->with('status',"User Deleted!");
    }



    
}

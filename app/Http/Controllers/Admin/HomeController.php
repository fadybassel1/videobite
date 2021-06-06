<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\models\Request;
use App\models\Video;

class HomeController extends Controller
{
    public function index()
    {
        $requests = Request::orderBy('created_at','asc')->orderBy('status','desc')->with('video')->paginate(2, ['*'], 'requests');
        $videos = Video::where('active_summary',"!=","NULL")->orderBy('created_at','desc')->with('summary')->paginate(2, ['*'], 'videos');
        return view("admin.dashboard",compact('requests','videos'));
    }
}

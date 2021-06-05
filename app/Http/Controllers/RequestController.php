<?php

namespace App\Http\Controllers;

use App\models\Request;

use App\models\Video;
use Illuminate\Support\Facades\Gate;


class RequestController extends Controller
{
    
    public function create($video_id)
    {
        $video =  Video::where('id',$video_id)->first();
        $response = Gate::inspect('create_edit_request', $video);
        if ($response->allowed()) {
            $summary = $video->summary()->first();
            $allowed = 1;
            return view('requests.create', compact(['summary', 'allowed']));
        } else if ($response->message() == "pending") {
            $allowed = 0;
            $request = $video->requests()->where("status", "pending")->first();
            return view('requests.create', compact(['request', 'allowed']));
        }else {
            return redirect()->back()->with('info',"Video has no Summary yet");
        }
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $video =  Video::where('id',$request->video)->first();
        $this->authorize('create_edit_request',$video);
        if($video->summaries()->get()->contains($request->summaryID))
        Request::create(['summary_id'=>$request->summaryID,'video_id'=>$request->video,'summary'=>$request->summary,'status'=>'pending']);
        return redirect()->back();
    }


    public function videoRequestsView($video_id)
    {
        $video =  Video::where('id',$video_id)->first();
        $this->authorize('view_requests',$video);

        $requests =  $video->requests()->orderBy('created_at',"DESC")->get();
        return view('requests.view',compact('requests'));
    }
    
}

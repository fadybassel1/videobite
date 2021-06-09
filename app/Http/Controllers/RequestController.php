<?php

namespace App\Http\Controllers;

use App\Notifications\Requests;
use App\models\Request;
use App\models\Video;
use App\models\Summary;
use Illuminate\Support\Facades\Gate;
use App\User;


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
            return redirect()->back()->with('info',"Video has no summary yet!");
        }
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $video =  Video::where('id',$request->video)->first();
        $this->authorize('create_edit_request',$video);
        if($video->summaries()->get()->contains($request->summaryID))
        Request::create(['summary_id'=>$request->summaryID,'video_id'=>$request->video,'summary'=>$request->summary,'status'=>'pending']);
        $users = User::whereHas(
            'roles', function($q){
                $q->where('name', 'admin');
            }
        )->get();
        foreach ($users as $user) {
            $user->notify(new Requests($video->id,"new"));
        }
        return redirect()->back();
    }


    public function videoRequestsView($video_id)
    {
        $video =  Video::where('id',$video_id)->first();
        $this->authorize('view_requests',$video);

        $requests =  $video->requests()->orderBy('created_at',"DESC")->get();
        return view('requests.view',compact('requests'));
    }

    public function changeStatus(\Illuminate\Http\Request $request)
    {
        $video =  Video::where('id',$request->videoId)->first();

        if($request->submitRequest == "Accept")
        {
            Request::where('summary_id', $request->summaryId)->where('video_id', $request->videoId)->update(['status' => 'accepted']);
            Summary::where('id', $request->summaryId)->update(['summary' => $request->summary]);
            User::find($video->user_id)->notify(new Requests($request->videoId,"Accepted"));
            return redirect()->back()->with('info',"Summary Accepted!");
        }

        else if($request->submitRequest == "Reject")
        {
            Request::where('summary_id',$request->summaryId)->where('video_id', $request->videoId)->update(['status'=> 'rejected']);
            User::find($video->user_id)->notify(new Requests($request->videoId,"Rejected"));
            return redirect()->back()->with('info',"Summary Rejected!");
        }
    }
    
}

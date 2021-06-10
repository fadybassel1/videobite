<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\Requests;
use App\models\Request;
use App\models\Video;
use App\models\Summary;
use Illuminate\Support\Facades\Gate;
use App\User;


class RequestControllerApi extends Controller
{
    
    public function create($video_id)
    {
        $video = auth()->user()->videos()->where('id',$video_id)->with('summary')->first();
        $response = Gate::inspect('create_edit_request', $video);
        if($response->allowed())
        {
            return response()->json([
                'message' => "allowed",
                'video' => $video,
            ]);
        } else if ($response->message() == "pending") {
            return response()->json([
                'message' => "pending",
            ]);
        }else {
            return response()->json([
                'message' => "Video has no summary yet!",
            ]);
        }
    }

    public function store(\Illuminate\Http\Request $request)
    {
        // return $request;
        $video =  auth()->user()->videos()->where('id',$request->video)->first();
        if($video->summaries()->get()->contains($request->summaryID))
            Request::create(['summary_id'=>$request->summaryID,'video_id'=>$request->video,'summary'=>$request->summary,'status'=>'pending']);
        // $users = User::whereHas(
        //     'roles', function($q){
        //         $q->where('name', 'admin');
        //     }
        // )->get();
        // foreach ($users as $user) {
        //     $user->notify(new Requests($video->id,"new"));
        // }
        return response()->json([
            'message' => "success"
        ]);
    }


    public function videoRequestsView($video_id)
    {
        $video =  auth()->user()->videos()->where('id',$video_id)->first();

        return $video->requests()->orderBy('created_at',"DESC")->get();
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

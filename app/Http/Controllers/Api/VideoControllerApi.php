<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\DataUpdated;
use App\models\Keyword;
use App\models\Summary;
use App\models\Timestamp;
use Illuminate\Support\Facades\Http;
use App\models\Video;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class VideoControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json([
            'status' => true,
            'data'=>auth()->user()->videos()->get(),
            'message'=>"success",
        ]);     
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if($request->hasFile('video')) {
        //     $name = time()."_".$request->file('image')->getClientOriginalName();
        //     $request->file('image')->move(public_path('images'), $name);
        // }
        // return response()->json([
        //     asset("images/$name"),
        //     201,
        //     'message' => asset("images/$name") ? 'Image saved' : 'Image failed to save'
        // ]);
        if($request->file('file')->extension() != "mp4")
        {
            return response()->json([
                    'message' => "Error",
            ]);
        }
        if($request->title == null || $request->title == "")
        {
            return response()->json([
                'message' => "Video name is required!",
            ]);
        }
        $video = $request->file('file');
        $FileName = explode('.',$video->getClientOriginalName())[0];
        $FileUniqueName = uniqid($FileName.'$').".".$video->getClientOriginalExtension();
        $path = Storage::putFileAs(
            'public/userVideos/'.auth()->user()->id,$video,$FileUniqueName
        );
        $videoUpload = new Video();
        $videoUpload->title = $request->title;
        $videoUpload->link = "/storage/userVideos/".auth()->user()->id."/".$FileUniqueName;
        $videoUpload->flag = "1";
        $videoUpload->user_id = auth()->user()->id;
        $videoUpload->save();
        // $message = $this->send_to_api($videoUpload->link,$FileName,$videoUpload->id);
        $message = "Video is sent to be processed!";
        return response()->json([
            'status' => true,
            'message' => $message,
        ]);
    }


    private function send_to_api($link,$FileName,$id){
        $link = str_replace('/','-',$link);
        $response = Http::get("http://192.168.0.16:8000/processvideo/$link/$id/$FileName");
        if($response->status()==200)
        return "Video is sent to be processed!";
        else return "Something went wrong while sending the video to be processed!";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($video)
    {
        return response()->json([
            'status' => true,
            'data' => auth()->user()->videos()->where('id',$video)->with('summary')->with('timestamps')->with('keywords')->first(),
            'message' => 'success',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Video  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $fileUpload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Video  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $fileUpload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Video  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $fileUpload = Video::find($id);
        $summary = Summary::where('video_id', $id);
        if($fileUpload->flag == 1)
        {
            $path = public_path().$fileUpload->link;
            if(file_exists($path))
                unlink($path);
        }
        
        $summary->delete();
        $fileUpload->delete();
        return response()->json([
            'message' => "deleted",
        ]);
    }
}
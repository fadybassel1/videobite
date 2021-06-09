<?php

namespace App\Http\Controllers;

use App\Notifications\DataUpdated;
use App\models\Keyword;
use App\models\Summary;
use App\models\Timestamp;
use Illuminate\Support\Facades\Http;
use App\models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $videos = auth()->user()->videos()->get();
        return view('files.index', compact('videos'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->file('file')->extension() != "mp4")
        {
            return redirect()->back()->with('error', "File extension must be .mp4");
        }
        if($request->title == null || $request->title == "")
        {
            return redirect()->back()->with('error', "Video name is required!");
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
        $message = $this->send_to_api($videoUpload->link,$FileName,$videoUpload->id);
        return redirect()->back()->with('info',$message);
    }


    private function send_to_api($link,$FileName,$id){
        $link = str_replace('/','-',$link);
        $response = Http::get("http://192.168.0.16:8000/processvideo/$link/$id/$FileName");
        if($response->status()==200)
        return "Video is sent to be processed!";
        else return "Something went wrong while sending the video to be processed!";
    }
    public function updateSummary(Request $request)
    {
        $results = $request->json()->all();
        $summary = new Summary(['video_id' => $results['video_id'],'summary'=>$results['summary']]);
        

        for ($i=0; $i < count($results['timestamps']) ; $i++) { 
            
            $t =  new Timestamp(['video_id' => $results['video_id'],'start_time'=> strval($results['timestamps'][$i]['start']),'end_time'=> strval($results['timestamps'][$i]['end']),'description'=> $results['timestamps'][$i]['sentence'] ]);
            $t->save();
        }

        for ($i=0; $i < count($results['keywords']) ; $i++) { 
            
            $k =  new Keyword(['video_id' => $results['video_id'],'keyword'=> $results['keywords'][$i]['parsed_value'] ]);
            $k->save();
        }

        $video = Video::find($results['video_id']);
        $summary = $video->summary()->save($summary);
        $video->active_summary = $summary->id;
        $video->save();
        // $video->active_summary=
        // $video->keywords()->save($keywords);
        $user->notify(new DataUpdated($video));
        return response()->json(['success' => 'Saved Successfully!']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show($video)
    {
        $video= Video::where('id',$video)->with('summary')->with('timestamps')->with('keywords')->first();
        if (auth()->user()->id == $video->user_id) {
            //dd($video);
           return view('viewVideo',compact('video'));
        }
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

        return redirect()->back()
            ->with('success', 'File deleted successfully!');
    }
}

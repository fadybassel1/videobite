<?php

namespace App\Http\Controllers;

use App\models\Summary;
use Illuminate\Support\Facades\Http;
use App\models\Video;
use Illuminate\Http\Request;

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
        $image = $request->file('file');
        $FileName = $image->getClientOriginalName();
        $image->move(public_path('videos'), $FileName);

        $videoUpload = new Video();
        $videoUpload->title = $FileName;
        $videoUpload->link = "/videos/$FileName";
        $videoUpload->flag = "1";
        $videoUpload->user_id = auth()->user()->id;
        $videoUpload->save();
        $message=$this->send_to_api($videoUpload->link,$videoUpload->id);
        return response()->json(['success' => $FileName,'message'=>$message]);
    }


    private function send_to_api($link,$id){
        $link = str_replace($link,'/','-');
        $response = Http::get("http://192.168.0.15:8000/processvideo/$link/$id");
        if($response->status()==200)
        return "video sent to be processed";
        else return "Something went wrong while sending the video to be processed";
    }
    public function updateSummary(Request $request)
    {
        $results = json_decode($request->getContent(), true);
        $summary = new Summary(['video_id' => $results['video_id'],'summary'=>$results['summary']]);
        $video = Video::find($results['video_id']);
        $video->summary()->save($summary);
        return response()->json(['success' => 'saved successfully']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Video  $fileUpload
     * @return \Illuminate\Http\Response
     */
    public function show(Video $fileUpload)
    {
        //
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

        $fileUpload->delete();

        return redirect()->back()
            ->with('success', 'File deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

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
        return response()->json(['success' => $FileName]);
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

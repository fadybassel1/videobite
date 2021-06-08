<?php

namespace App\Http\Controllers;

use App\models\Summary;
use App\models\Video;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
   public function view($video)
   {
      $video = Video::find($video);
      $this->authorize('view_summaries', $video);
      $summaries = $video->summaries()->get();
      return view('summary.view', compact(['summaries', 'video']));
   }

   public function update($summary)
   {
      $summary = Summary::where('id', $summary)->with('video')->first();
      if($summary){
      if (auth()->user()->videos->contains($summary->video->id)) {
         $summary->video->active_summary = $summary->id;
         $summary->video->save();
         return redirect()->back()->with('success', 'updated successfuly');
      } }
      else {
         return redirect()->back()->with('error', 'not authroized');
      }
   }
}

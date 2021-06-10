<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\models\Summary;
use App\models\Video;
use Illuminate\Http\Request;

class SummaryControllerApi extends Controller
{
   public function view($video)
   {
      $video = auth()->user()->videos()->find($video);
      $summaries = $video->summaries()->get();
      return $summaries;
   }

   public function update($summary)
   {
      $summary = Summary::where('id', $summary)->with('video')->first();
      if($summary){
      if (auth()->user()->videos->contains($summary->video->id)) {
         $summary->video->active_summary = $summary->id;
         $summary->video->save();
         return response()->json([
            'message' => "updated successfuly",
         ]);
      } }
      else {
         return response()->json([
            'message' => "not authroized",
         ]);
      }
   }
}

<?php

namespace App\Http\Controllers;

use App\models\Video;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
   public function view($video){
        $video = Video::find($video);
        $this->authorize('view_summaries',$video);
        $summaries = $video->summaries()->get();
        return view('summary.view',compact(['summaries','video']));
   }
}
